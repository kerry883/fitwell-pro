<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display the user's settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notificationTypes = ['new_program_assigned', 'program_progress_updated', 'new_message_received', 'appointment_reminder'];

        // Ensure default preferences exist
        foreach ($notificationTypes as $type) {
            NotificationPreference::query()->firstOrCreate(
                ['user_id' => $user->id, 'notification_type' => $type],
                ['in_app' => true, 'email' => false] // Default values
            );
        }

        $preferences = $user->notificationPreferences()->get()->keyBy('notification_type');

        return view('settings.client', compact('notificationTypes', 'preferences'));
    }

    /**
     * Update the user's notification settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notificationTypes = ['new_program_assigned', 'program_progress_updated', 'new_message_received', 'appointment_reminder'];
        
        try {
            foreach ($notificationTypes as $type) {
                $inApp = $request->input("notifications.{$type}.in_app", false);
                $email = $request->input("notifications.{$type}.email", false);

                NotificationPreference::query()->updateOrCreate(
                    ['user_id' => $user->id, 'notification_type' => $type],
                    ['in_app' => (bool)$inApp, 'email' => (bool)$email]
                );
            }

            return back()->with('success', 'Notification settings updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating notification settings for user ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
