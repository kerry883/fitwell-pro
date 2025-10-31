<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ProgramAssignment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // Log for debugging
        Log::info('Payment checkout attempt', [
            'assignment_id' => $assignmentId,
            'user_id' => auth()->id(),
            'assignment_status' => $assignment->status->value,
            'assignment_client_user_id' => $assignment->client->user_id,
            'program_is_free' => $assignment->program->is_free,
            'program_price' => $assignment->program->price,
        ]);

        // Verify the assignment belongs to the authenticated user
        if ($assignment->client->user_id !== auth()->id()) {
            Log::warning('Unauthorized payment checkout attempt', [
                'assignment_id' => $assignmentId,
                'user_id' => auth()->id(),
                'assignment_client_user_id' => $assignment->client->user_id,
            ]);
            abort(403, 'Unauthorized access to this payment.');
        }

        // Verify the assignment is pending payment
        if ($assignment->status->value !== 'pending_payment') {
            Log::warning('Payment checkout for non-pending assignment', [
                'assignment_id' => $assignmentId,
                'status' => $assignment->status->value,
            ]);
            return redirect()->route('client.dashboard')
                ->with('error', 'This enrollment is not pending payment. Current status: ' . $assignment->status->value);
        }

        $program = $assignment->program;

        // Verify the program is not free (extra safety check)
        if ($program->is_free) {
            Log::warning('Payment checkout attempted for free program', [
                'assignment_id' => $assignmentId,
                'program_id' => $program->id,
            ]);
            return redirect()->route('client.assignments.index')
                ->with('error', 'This program is free and does not require payment.');
        }

        // Create payment intent
        $result = $this->paymentService->createPaymentIntent(auth()->user(), $assignment);

        if (!$result['success']) {
            Log::error('Payment intent creation failed', [
                'assignment_id' => $assignmentId,
                'error' => $result['error'] ?? 'Unknown error',
            ]);
            return redirect()->route('client.dashboard')
                ->with('error', $result['error'] ?? 'Unable to create payment. Please try again.');
        }

        Log::info('Payment checkout page loaded successfully', [
            'assignment_id' => $assignmentId,
            'payment_id' => $result['payment_id'],
        ]);

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

        $payment = Payment::with(['assignment.program'])
            ->where('user_id', auth()->id())
            ->findOrFail($paymentId);

        if (!$payment->canRefund()) {
            return redirect()->back()
                ->with('error', 'This payment is not eligible for a refund.');
        }

        $result = $this->paymentService->requestRefund($payment, $request->reason);

        if ($result['success']) {
            return redirect()->route('client.payment.history')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['error']);
    }
}
