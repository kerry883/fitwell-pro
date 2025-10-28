<?php

namespace App\Notifications;

use App\Models\ProgramAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientActivatedNotification extends Notification
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
        $isPaid = !$this->assignment->program->is_free;
        
        return (new MailMessage)
            ->subject('New Client Activated: ' . $this->assignment->user->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new client has been activated for your program!')
            ->line('**Client Details:**')
            ->line('• Name: ' . $this->assignment->user->name)
            ->line('• Program: ' . $this->assignment->program->title)
            ->line('• Duration: ' . $this->assignment->program->duration_weeks . ' weeks')
            ->when($isPaid, function ($mail) {
                return $mail->line('• Payment: $' . number_format($this->assignment->program->price, 2) . ' received');
            })
            ->line('• Activated: ' . now()->format('M d, Y H:i'))
            ->action('View Client', route('trainer.assignments.index'))
            ->line('You can now begin working with this client!');
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
            'client_id' => $this->assignment->user->id,
            'client_name' => $this->assignment->user->name,
            'program_id' => $this->assignment->program->id,
            'program_title' => $this->assignment->program->title,
            'is_paid' => !$this->assignment->program->is_free,
            'message' => 'New client activated: ' . $this->assignment->user->name,
            'action_url' => route('trainer.assignments.index'),
        ];
    }
}
