<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class FailedEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $failedJob;

    public function __construct($failedJob)
    {
        $this->failedJob = $failedJob;
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->error()
            ->content('Email Job Failed!')
            ->attachment(function ($attachment) {
                $attachment
                    ->title('Job Details')
                    ->fields([
                        'Job ID' => $this->failedJob->job_id ?? 'N/A',
                        'Queue' => $this->failedJob->queue ?? 'default',
                        'Attempt' => $this->failedJob->attempts ?? 1,
                        'Exception' => $this->failedJob->exception ?? 'No exception details',
                    ]);
            });
    }
}