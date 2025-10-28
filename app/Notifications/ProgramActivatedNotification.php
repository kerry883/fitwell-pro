<?php

namespace App\Notifications;

use App\Models\ProgramAssignment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProgramActivatedNotification extends Notification
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
            ->subject('🎉 Your Program is Now Active!')
            ->greeting('Great News!')
            ->line('Your enrollment in **' . $this->assignment->program->title . '** has been approved and activated!')
            ->line('You can start your fitness journey immediately.')
            ->line('**Program Details:**')
            ->line('• Duration: ' . $this->assignment->program->duration_weeks . ' weeks')
            ->line('• Category: ' . ucfirst($this->assignment->program->category))
            ->line('• Start Date: ' . now()->format('M d, Y'))
            ->action('View Program', route('client.programs.show', $this->assignment->program))
            ->line('Your trainer is ready to guide you. Good luck!');
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
            'message' => 'Your enrollment has been approved and activated!',
            'action_url' => route('client.programs.show', $this->assignment->program),
        ];
    }
}
