<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\ProgramAssignment;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Initiate M-Pesa STK Push payment
     */
    public function initiatePayment(Request $request, $assignmentId)
    {
        try {
            $assignment = ProgramAssignment::with(['program', 'client.user'])
                ->findOrFail($assignmentId);

            // Verify the assignment belongs to the authenticated user
            if ($assignment->client->user_id !== request()->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to this payment'
                ], 403);
            }

            // Verify the assignment is pending payment
            if ($assignment->status->value !== 'pending_payment') {
                return response()->json([
                    'success' => false,
                    'message' => 'This enrollment is not pending payment'
                ], 400);
            }

            // Use price directly in KES (no conversion needed)
            $amount = ceil($assignment->program->getPriceInKES());
            $phoneNumber = $request->phone_number;
            $reference = "FW{$assignment->id}"; // FW = FitWell
            $description = "Payment for {$assignment->program->name}";

            $result = $this->mpesaService->initiateSTKPush(
                $phoneNumber,
                $amount,
                $reference,
                $description
            );

            if ($result['success']) {
                // Store the CheckoutRequestID for later verification
                Payment::create([
                    'user_id' => $assignment->client->user_id,
                    'program_assignment_id' => $assignment->id,
                    'program_id' => $assignment->program_id,
                    'trainer_id' => $assignment->program->trainer_id,
                    'amount' => $amount,
                    'currency' => 'KES',
                    'payment_method' => 'mpesa',
                    'payment_type' => 'one_time',
                    'status' => 'pending',
                    'transaction_id' => $result['CheckoutRequestID'],
                    'metadata' => [
                        'phone_number' => $phoneNumber,
                        'checkout_request_id' => $result['CheckoutRequestID']
                    ]
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Please check your phone to complete payment',
                    'data' => $result
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);

        } catch (\Exception $e) {
            Log::error('M-Pesa payment initiation error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate payment. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle M-Pesa callback
     */
    public function handleCallback(Request $request)
    {
        try {
            Log::info('M-Pesa callback received', ['data' => $request->all()]);

            $callbackData = $request->Body->stkCallback;
            $checkoutRequestId = $callbackData->CheckoutRequestID;
            $resultCode = $callbackData->ResultCode;

            // Find the payment by CheckoutRequestID
            $payment = Payment::where('transaction_id', $checkoutRequestId)->first();
            if (!$payment) {
                Log::error('M-Pesa payment not found', ['checkout_request_id' => $checkoutRequestId]);
                return response()->json(['success' => false]);
            }

            if ($resultCode == 0) {
                // Payment successful
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'mpesa_receipt' => $callbackData->CallbackMetadata->Item[1]->Value ?? null,
                        'transaction_date' => $callbackData->CallbackMetadata->Item[3]->Value ?? null,
                    ])
                ]);

                // Update program assignment
                $payment->programAssignment->update([
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'activated_at' => now()
                ]);

                // Fire payment completed event and notification
                event(new \App\Events\MpesaPaymentConfirmed($payment));
                $payment->user->notify(new \App\Notifications\MpesaPaymentSuccessful($payment));
            } else {
                // Payment failed
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'result_code' => $resultCode,
                        'result_desc' => $callbackData->ResultDesc
                    ])
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('M-Pesa callback error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false]);
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Request $request, $assignmentId)
    {
        try {
            $assignment = ProgramAssignment::with(['payment'])
                ->findOrFail($assignmentId);

            if ($assignment->client->user_id !== request()->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if (!$assignment->payment || $assignment->payment->payment_method !== 'mpesa') {
                return response()->json([
                    'success' => false,
                    'message' => 'No M-Pesa payment found for this enrollment'
                ], 404);
            }

            $checkoutRequestId = $assignment->payment->transaction_id;
            $result = $this->mpesaService->querySTKStatus($checkoutRequestId);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            Log::error('M-Pesa status check error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to check payment status'
            ], 500);
        }
    }
}