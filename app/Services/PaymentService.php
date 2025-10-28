<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Program;
use App\Models\ProgramAssignment;
use App\Models\User;
use App\Enums\ProgramAssignmentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;

class PaymentService
{
    /**
     * Create a Stripe payment intent for a program enrollment.
     */
    public function createPaymentIntent(User $user, ProgramAssignment $assignment): array
    {
        try {
            $program = $assignment->program;
            
            // Ensure user has a Stripe customer ID
            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer([
                    'name' => $user->full_name,
                    'email' => $user->email,
                ]);
            }

            // Create payment intent using Stripe API directly
            $stripe = new \Stripe\StripeClient(config('cashier.secret'));
            
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $program->price * 100, // Convert to cents
                'currency' => 'usd',
                'customer' => $user->stripeId(),
                'metadata' => [
                    'program_id' => $program->id,
                    'program_name' => $program->name,
                    'assignment_id' => $assignment->id,
                    'trainer_id' => $program->trainer_id,
                    'user_id' => $user->id,
                ],
                'description' => "Payment for {$program->name}",
            ]);

            // Create payment record in database
            $payment = Payment::create([
                'user_id' => $user->id,
                'program_assignment_id' => $assignment->id,
                'program_id' => $program->id,
                'trainer_id' => $program->trainer_id,
                'amount' => $program->price,
                'currency' => 'usd',
                'payment_type' => 'one_time',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_customer_id' => $user->stripeId(),
                'status' => 'pending',
            ]);

            return [
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $payment->id,
                'amount' => $program->price,
            ];
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment intent creation failed', [
                'user_id' => $user->id,
                'assignment_id' => $assignment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Unable to create payment. Please try again later.',
            ];
        }
    }

    /**
     * Process a successful payment and activate the program assignment.
     */
    public function processSuccessfulPayment(string $paymentIntentId): bool
    {
        DB::beginTransaction();

        try {
            // Find payment by Stripe payment intent ID
            $payment = Payment::where('stripe_payment_intent_id', $paymentIntentId)->firstOrFail();

            // Update payment status
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Activate the program assignment
            $assignment = $payment->assignment;
            $assignment->update([
                'status' => ProgramAssignmentStatus::ACTIVE,
                'start_date' => now(),
                'end_date' => now()->addWeeks($assignment->program->duration_weeks),
            ]);

            // Increment program's current_clients counter
            $assignment->program->increment('current_clients');

            DB::commit();

            // Send notification to client about activation
            $assignment->user->notify(new \App\Notifications\ProgramActivatedNotification($assignment));

            // Send notification to trainer about new active client
            $assignment->program->trainer->user->notify(
                new \App\Notifications\ClientActivatedNotification($assignment)
            );

            Log::info('Payment processed successfully', [
                'payment_id' => $payment->id,
                'assignment_id' => $assignment->id,
            ]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to process successful payment', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Handle failed payment.
     */
    public function processFailedPayment(string $paymentIntentId, string $failureReason = null): void
    {
        try {
            $payment = Payment::where('stripe_payment_intent_id', $paymentIntentId)->first();

            if ($payment) {
                $payment->update([
                    'status' => 'failed',
                    'metadata' => array_merge($payment->metadata ?? [], [
                        'failure_reason' => $failureReason,
                        'failed_at' => now()->toISOString(),
                    ]),
                ]);

                // Notify user about failed payment
                $payment->user->notify(new \App\Notifications\PaymentFailedNotification($payment));
            }
        } catch (\Exception $e) {
            Log::error('Failed to process failed payment', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Process a refund request.
     */
    public function processRefund(Payment $payment, string $reason = null): array
    {
        try {
            // Check if refund is allowed
            if (!$payment->canRefund()) {
                return [
                    'success' => false,
                    'error' => 'Refund period has expired or payment is not eligible for refund.',
                ];
            }

            DB::beginTransaction();

            // Process refund through Stripe
            $user = $payment->user;
            $refund = $user->refund($payment->stripe_payment_intent_id);

            // Update payment record
            $payment->update([
                'status' => 'refunded',
                'refunded_at' => now(),
                'refund_amount' => $payment->amount,
                'refund_reason' => $reason,
            ]);

            // Deactivate the program assignment
            $assignment = $payment->assignment;
            if ($assignment) {
                $assignment->update([
                    'status' => ProgramAssignmentStatus::CANCELLED,
                ]);

                // Decrement program's current_clients counter
                $assignment->program->decrement('current_clients');
            }

            DB::commit();

            // Send refund confirmation notification
            $user->notify(new \App\Notifications\RefundProcessedNotification($payment));

            Log::info('Refund processed successfully', [
                'payment_id' => $payment->id,
                'refund_amount' => $payment->amount,
            ]);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'amount' => $payment->amount,
            ];
        } catch (ApiErrorException $e) {
            DB::rollBack();
            
            Log::error('Stripe refund failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Unable to process refund. Please contact support.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Refund processing failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'An error occurred while processing the refund.',
            ];
        }
    }

    /**
     * Cancel expired payment assignments.
     */
    public function cancelExpiredPayments(): int
    {
        $expiredAssignments = ProgramAssignment::where('status', ProgramAssignmentStatus::PENDING_PAYMENT)
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '<', now())
            ->get();

        $cancelledCount = 0;

        foreach ($expiredAssignments as $assignment) {
            try {
                DB::beginTransaction();

                // Update assignment status
                $assignment->update([
                    'status' => ProgramAssignmentStatus::CANCELLED,
                    'notes' => 'Automatically cancelled due to payment deadline expiry.',
                ]);

                // Cancel any pending payment records
                Payment::where('program_assignment_id', $assignment->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'cancelled']);

                DB::commit();

                // Notify user about cancellation
                $assignment->user->notify(
                    new \App\Notifications\EnrollmentCancelledNotification($assignment, 'Payment deadline expired')
                );

                $cancelledCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Failed to cancel expired payment assignment', [
                    'assignment_id' => $assignment->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Expired payment assignments cancelled', ['count' => $cancelledCount]);

        return $cancelledCount;
    }

    /**
     * Send payment reminders for assignments approaching deadline.
     */
    public function sendPaymentReminders(): int
    {
        // Find assignments pending payment with deadline within next 24 hours
        // that haven't received a reminder yet or last reminder was sent more than 12 hours ago
        $assignments = ProgramAssignment::where('status', ProgramAssignmentStatus::PENDING_PAYMENT)
            ->whereNotNull('payment_deadline')
            ->where('payment_deadline', '>', now())
            ->where('payment_deadline', '<=', now()->addHours(24))
            ->where(function ($query) {
                $query->whereNull('payment_reminder_sent_at')
                    ->orWhere('payment_reminder_sent_at', '<=', now()->subHours(12));
            })
            ->get();

        $remindersSent = 0;

        foreach ($assignments as $assignment) {
            try {
                // Send reminder notification
                $assignment->user->notify(
                    new \App\Notifications\PaymentReminderNotification($assignment)
                );

                // Update reminder timestamp
                $assignment->update([
                    'payment_reminder_sent_at' => now(),
                ]);

                $remindersSent++;
            } catch (\Exception $e) {
                Log::error('Failed to send payment reminder', [
                    'assignment_id' => $assignment->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Payment reminders sent', ['count' => $remindersSent]);

        return $remindersSent;
    }
}
