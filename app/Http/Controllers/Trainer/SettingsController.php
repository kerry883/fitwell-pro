<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Display the trainer's settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notificationTypes = ['client_milestone_achieved', 'new_client_assigned', 'client_sent_message', 'weekly_summary_report'];

        // Ensure default preferences exist
        foreach ($notificationTypes as $type) {
            NotificationPreference::query()->firstOrCreate(
                ['user_id' => $user->id, 'notification_type' => $type],
                ['in_app' => true, 'email' => false] // Default values
            );
        }

        $preferences = $user->notificationPreferences()->get()->keyBy('notification_type');

        return view('settings.trainer', compact('notificationTypes', 'preferences'));
    }

    /**
     * Update the trainer's notification settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notificationTypes = ['client_milestone_achieved', 'new_client_assigned', 'client_sent_message', 'weekly_summary_report'];
        
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
            Log::error('Error updating notification settings for trainer ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
