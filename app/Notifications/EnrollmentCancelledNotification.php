<?php

namespace App\Notifications;

use App\Models\ProgramAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnrollmentCancelledNotification extends Notification
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
        return (new MailMessage)
            ->subject('Enrollment Cancelled - Payment Deadline Expired')
            ->error()
            ->greeting('Enrollment Cancelled')
            ->line('Your enrollment for **' . $this->assignment->program->title . '** has been cancelled.')
            ->line('**Reason:** Payment deadline expired')
            ->line('**Program Details:**')
            ->line('• Program: ' . $this->assignment->program->title)
            ->line('• Price: $' . number_format($this->assignment->program->price, 2))
            ->line('• Deadline Passed: ' . $this->assignment->payment_deadline->format('M d, Y H:i'))
            ->line('**What This Means:**')
            ->line('• Your enrollment has been removed')
            ->line('• No payment has been charged')
            ->line('• You can re-enroll at any time')
            ->action('Browse Programs', route('client.programs.index'))
            ->line('We\'re sorry to see you go. If you have questions, please contact our support team.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->id,
            'program_id' => $this->assignment->program->id,
            'program_title' => $this->assignment->program->title,
            'reason' => 'Payment deadline expired',
            'deadline' => $this->assignment->payment_deadline?->toIso8601String(),
            'message' => 'Enrollment cancelled due to payment deadline expiry',
            'action_url' => route('client.programs.index'),
        ];
    }
}
