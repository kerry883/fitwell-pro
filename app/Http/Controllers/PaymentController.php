<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ProgramAssignment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Show the payment checkout page.
     */
    public function checkout($assignmentId)
    {
        $assignment = ProgramAssignment::with(['program', 'client.user'])
            ->findOrFail($assignmentId);

        // Verify the assignment belongs to the authenticated user
        if ($assignment->client->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this payment.');
        }

        // Verify the assignment is pending payment
        if ($assignment->status->value !== 'pending_payment') {
            return redirect()->route('client.dashboard')
                ->with('error', 'This enrollment is not pending payment.');
        }

        $program = $assignment->program;

        // Verify the program is not free (extra safety check)
        if ($program->is_free) {
            return redirect()->route('client.assignments.index')
                ->with('error', 'This program is free and does not require payment.');
        }

        // Create payment intent
        $result = $this->paymentService->createPaymentIntent(auth()->user(), $assignment);

        if (!$result['success']) {
            return redirect()->route('client.dashboard')
                ->with('error', $result['error']);
        }

        return view('client.payment.checkout', [
            'assignment' => $assignment,
            'program' => $program,
            'clientSecret' => $result['client_secret'],
            'amount' => $result['amount'],
            'paymentId' => $result['payment_id'],
        ]);
    }

    /**
     * Handle successful payment redirect.
     */
    public function success($assignmentId)
    {
        $assignment = ProgramAssignment::with(['program'])
            ->findOrFail($assignmentId);

        // Verify the assignment belongs to the authenticated user
        if ($assignment->client->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('client.payment.success', [
            'assignment' => $assignment,
            'program' => $assignment->program,
        ]);
    }

    /**
     * Handle failed payment.
     */
    public function failed(Request $request)
    {
        $assignmentId = $request->query('assignment_id');
        $assignment = ProgramAssignment::with(['program'])->findOrFail($assignmentId);

        // Verify the assignment belongs to the authenticated user
        if ($assignment->client->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('client.payment.failed', [
            'assignment' => $assignment,
            'program' => $assignment->program,
            'error' => $request->query('error', 'Payment failed. Please try again.'),
        ]);
    }

    /**
     * Handle Stripe webhook events.
     */
    public function webhook(Request $request)
    {
        try {
            // Verify webhook signature
            $payload = $request->getContent();
            $signature = $request->header('Stripe-Signature');
            $webhookSecret = config('services.stripe.webhook.secret');

            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $signature,
                    $webhookSecret
                );
            } catch (\UnexpectedValueException $e) {
                // Invalid payload
                Log::error('Invalid webhook payload', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid payload'], 400);
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                Log::error('Invalid webhook signature', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Invalid signature'], 400);
            }

            // Handle the event
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $paymentIntent = $event->data->object;
                    $this->paymentService->processSuccessfulPayment($paymentIntent->id);
                    break;

                case 'payment_intent.payment_failed':
                    $paymentIntent = $event->data->object;
                    $failureReason = $paymentIntent->last_payment_error->message ?? 'Unknown error';
                    $this->paymentService->processFailedPayment($paymentIntent->id, $failureReason);
                    break;

                case 'charge.refunded':
                    $charge = $event->data->object;
                    // Handle refund webhook if needed
                    Log::info('Charge refunded webhook received', ['charge_id' => $charge->id]);
                    break;

                default:
                    Log::info('Unhandled webhook event type', ['type' => $event->type]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    /**
     * Show payment history for the authenticated user.
     */
    public function history()
    {
        $payments = Payment::with(['program', 'assignment'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.payment.history', compact('payments'));
    }

    /**
     * Request a refund for a payment.
     */
    public function requestRefund($paymentId)
    {
        $payment = Payment::with(['assignment.program'])
            ->where('user_id', auth()->id())
            ->findOrFail($paymentId);

        if (!$payment->canRefund()) {
            return redirect()->back()
                ->with('error', 'This payment is not eligible for a refund.');
        }

        return view('client.payment.refund', compact('payment'));
    }

    /**
     * Process refund request.
     */
    public function processRefund(Request $request, $paymentId)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $payment = Payment::where('user_id', auth()->id())->findOrFail($paymentId);

        $result = $this->paymentService->processRefund($payment, $request->reason);

        if ($result['success']) {
            return redirect()->route('client.payment.history')
                ->with('success', 'Refund processed successfully. Amount: $' . $result['amount']);
        }

        return redirect()->back()
            ->with('error', $result['error']);
    }
}

