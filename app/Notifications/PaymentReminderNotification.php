<?php

namespace App\Notifications;

use App\Models\ProgramAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ProgramAssignment $assignment)
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
        $deadline = $this->assignment->payment_deadline;
        $hoursLeft = $deadline ? now()->diffInHours($deadline) : 0;
        
        return (new MailMessage)
            ->subject('⏰ Payment Reminder - ' . $hoursLeft . ' Hours Left')
            ->greeting('Payment Reminder')
            ->line('This is a friendly reminder to complete your payment for **' . $this->assignment->program->title . '**.')
            ->line('**Program Details:**')
            ->line('• Program: ' . $this->assignment->program->title)
            ->line('• Price: $' . number_format($this->assignment->program->price, 2))
            ->line('• Trainer: ' . $this->assignment->program->user->name)
            ->line('• Duration: ' . $this->assignment->program->duration_weeks . ' weeks')
            ->line('⏰ **Time Remaining:** ' . $hoursLeft . ' hours')
            ->line('**Important:**')
            ->line('• If payment is not received by the deadline, your enrollment will be cancelled')
            ->line('• No charges will be made after cancellation')
            ->line('• You can re-enroll anytime after cancellation')
            ->action('Complete Payment Now', route('client.payment.checkout', $this->assignment))
            ->line('Need help? Contact our support team anytime!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $deadline = $this->assignment->payment_deadline;
        
        return [
            'assignment_id' => $this->assignment->id,
            'program_id' => $this->assignment->program->id,
            'program_title' => $this->assignment->program->title,
            'amount' => $this->assignment->program->price,
            'deadline' => $deadline?->toIso8601String(),
            'hours_left' => $deadline ? now()->diffInHours($deadline) : 0,
            'message' => 'Payment reminder: ' . ($deadline ? now()->diffInHours($deadline) : 0) . ' hours left',
            'action_url' => route('client.payment.checkout', $this->assignment),
        ];
    }
}
