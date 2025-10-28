<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentFailedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Payment $payment, public string $reason = 'Unknown error')
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
        $deadline = $this->payment->assignment->payment_deadline;
        $hoursLeft = $deadline ? now()->diffInHours($deadline) : 0;
        
        return (new MailMessage)
            ->subject('Payment Failed - Action Required')
            ->error()
            ->greeting('Payment Failed')
            ->line('Your payment for **' . $this->payment->program->title . '** could not be processed.')
            ->line('**Reason:** ' . $this->reason)
            ->line('**Common Issues:**')
            ->line('• Insufficient funds in your account')
            ->line('• Card declined by your bank')
            ->line('• Incorrect card details or expired card')
            ->line('• Card limits exceeded')
            ->when($deadline && $hoursLeft > 0, function ($mail) use ($hoursLeft) {
                return $mail->line('⏰ **Time Remaining:** ' . $hoursLeft . ' hours until deadline');
            })
            ->action('Try Again', route('client.payment.checkout', $this->payment->assignment))
            ->line('If the problem persists, please contact your bank or our support team.');
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
            'assignment_id' => $this->payment->assignment->id,
            'program_id' => $this->payment->program->id,
            'program_title' => $this->payment->program->title,
            'amount' => $this->payment->amount,
            'reason' => $this->reason,
            'deadline' => $this->payment->assignment->payment_deadline?->toIso8601String(),
            'message' => 'Payment failed. Please try again.',
            'action_url' => route('client.payment.checkout', $this->payment->assignment),
        ];
    }
}
