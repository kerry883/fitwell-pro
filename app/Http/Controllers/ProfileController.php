<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isClient()) {
            $profile = $user->clientProfile;
            return view('profile.index', compact('profile'));
        } elseif ($user->isTrainer()) {
            $profile = $user->trainerProfile;
            return view('trainer.profile.index', compact('profile'));
        }

        return view('profile.index');
    }

    /**
     * Update client goals.
     */
    public function updateGoals(Request $request)
    {
        $request->validate([
            'goals' => 'nullable|array',
            'goals.*' => 'string|max:255',
        ]);

        $user = Auth::user();
        if ($user->isClient()) {
            $user->clientProfile->update([
                'goals' => $request->goals,
            ]);

            return redirect()->back()->with('success', 'Fitness goals updated successfully!');
        }

        return redirect()->back()->with('error', 'Unable to update goals.');
    }

    /**
     * Update client profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:13|max:120',
            'height' => 'nullable|numeric|min:50|max:300',
            'weight' => 'nullable|numeric|min:20|max:500',
            'fitness_level' => 'nullable|in:beginner,intermediate,advanced',
            'activity_level' => 'nullable|in:sedentary,lightly_active,moderately_active,very_active,extremely_active',
            'experience_level' => 'nullable|in:beginner,intermediate,advanced',
            'available_days_per_week' => 'nullable|integer|min:1|max:7',
            'workout_duration_preference' => 'nullable|integer|min:15|max:180',
            'preferred_workout_time' => 'nullable|date_format:H:i',
            'preferred_workout_types' => 'nullable|array',
            'preferred_workout_types.*' => 'string',
            'medical_conditions' => 'nullable|array',
            'medical_conditions.*' => 'string',
            'injuries' => 'nullable|array',
            'injuries.*' => 'string',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'age' => $request->age,
            'height' => $request->height,
            'weight' => $request->weight,
            'fitness_level' => $request->fitness_level,
            'activity_level' => $request->activity_level,
        ]);

        if ($user->isClient()) {
            $user->clientProfile->update([
                'experience_level' => $request->experience_level,
                'available_days_per_week' => $request->available_days_per_week,
                'workout_duration_preference' => $request->workout_duration_preference,
                'preferred_workout_time' => $request->preferred_workout_time,
                'preferred_workout_types' => $request->preferred_workout_types,
                'medical_conditions' => $request->medical_conditions,
                'injuries' => $request->injuries,
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-photos', $filename, 'public');

            $user->update(['profile_picture' => $path]);

            return redirect()->back()->with('success', 'Profile photo updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to upload photo.');
    }
}
