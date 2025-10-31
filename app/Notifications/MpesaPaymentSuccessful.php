<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MpesaPaymentSuccessful extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Payment $payment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('M-Pesa Payment Confirmed')
            ->line('Your payment for ' . $this->payment->assignment->program->name . ' has been confirmed.')
            ->line('Payment details:')
            ->line('- Amount: KES ' . number_format($this->payment->amount, 2))
            ->line('- Transaction ID: ' . $this->payment->transaction_id)
            ->line('- Date: ' . $this->payment->paid_at->format('M j, Y'))
            ->line('Thank you for choosing FitWell Pro!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'type' => 'payment_confirmation',
            'payment_id' => $this->payment->id,
            'program_id' => $this->payment->program_id,
            'amount' => $this->payment->amount,
            'currency' => $this->payment->currency,
            'transaction_id' => $this->payment->transaction_id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'payment_confirmation',
            'payment_id' => $this->payment->id,
            'program_id' => $this->payment->program_id,
            'amount' => $this->payment->amount,
            'currency' => $this->payment->currency,
            'transaction_id' => $this->payment->transaction_id,
            'message' => 'Your M-Pesa payment for ' . $this->payment->assignment->program->name . ' has been confirmed.',
        ]);
    }
}