<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefundProcessedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Payment $payment)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Refund Processed Successfully')
            ->greeting('Refund Confirmation')
            ->line('Your refund request for **' . $this->payment->program->title . '** has been processed.')
            ->line('**Refund Details:**')
            ->line('• Amount: $' . number_format($this->payment->refund_amount, 2))
            ->line('• Payment Method: ' . ucfirst($this->payment->payment_method))
            ->line('• Transaction ID: ' . $this->payment->stripe_payment_intent_id)
            ->line('• Processed: ' . $this->payment->refunded_at->format('M d, Y H:i'))
            ->line('**What Happens Next:**')
            ->line('• Refund will appear in your account within 5-10 business days')
            ->line('• Your program enrollment has been cancelled')
            ->line('• You no longer have access to the program content')
            ->when($this->payment->refund_reason, function ($mail) {
                return $mail->line('**Reason:** ' . $this->payment->refund_reason);
            })
            ->action('View Payment History', route('client.payment.history'))
            ->line('Thank you for using FitWell Pro. We hope to serve you again!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'program_id' => $this->payment->program->id,
            'program_title' => $this->payment->program->title,
            'refund_amount' => $this->payment->refund_amount,
            'refunded_at' => $this->payment->refunded_at->toIso8601String(),
            'message' => 'Refund of $' . number_format($this->payment->refund_amount, 2) . ' processed successfully',
            'action_url' => route('client.payment.history'),
        ];
    }
}
