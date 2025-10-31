<?php

namespace App\Channels;

use App\Models\Notification;
use Illuminate\Notifications\Notification as IlluminateNotification;

class CustomDatabaseChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, IlluminateNotification $notification)
    {
        $data = $notification->toArray($notifiable);

        // Extract title and message from the notification data
        $title = $data['title'] ?? 'Notification';
        $message = $data['message'] ?? '';
        $type = $data['type'] ?? get_class($notification);
        
        // Remove title, message, and type from data as they're separate columns
        $additionalData = $data['data'] ?? $data;
        if (isset($additionalData['title'])) unset($additionalData['title']);
        if (isset($additionalData['message'])) unset($additionalData['message']);
        if (isset($additionalData['type'])) unset($additionalData['type']);

        // Create the notification
        return Notification::create([
            'user_id' => $notifiable->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $additionalData,
            'is_read' => false,
        ]);
    }
}
