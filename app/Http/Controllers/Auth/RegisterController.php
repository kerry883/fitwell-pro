<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ClientProfile;
use App\Models\TrainerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Prevent admin registration through regular form
        if ($request->user_type === 'admin') {
            return redirect()->back()->withErrors([
                'user_type' => 'Administrator accounts cannot be created through public registration.'
            ]);
        }

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required', 'in:client,trainer'],
        ];

        // Client-specific validation rules
        if ($request->user_type === 'client') {
            $rules = array_merge($rules, [
                'gender' => ['nullable', 'in:male,female,other'],
                'age' => ['nullable', 'integer', 'min:13', 'max:120'],
                'height' => ['nullable', 'numeric', 'min:100', 'max:250'],
                'weight' => ['nullable', 'numeric', 'min:30', 'max:300'],
                'fitness_level' => ['nullable', 'in:beginner,intermediate,advanced'],
                'activity_level' => ['nullable', 'in:sedentary,lightly_active,moderately_active,very_active,extremely_active'],
                'fitness_goals' => ['nullable', 'string', 'max:1000'],
            ]);
        }

        // Trainer-specific validation rules
        if ($request->user_type === 'trainer') {
            $rules = array_merge($rules, [
                'specializations' => ['nullable', 'string', 'max:1000'],
                'bio' => ['nullable', 'string', 'max:2000'],
                'years_experience' => ['nullable', 'integer', 'min:0', 'max:50'],
                'hourly_rate' => ['nullable', 'numeric', 'min:1', 'max:1000'],
            ]);
        }

        $validated = $request->validate($rules);

        try {
            \DB::beginTransaction();

            // Create the user
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_type' => $validated['user_type'],
                'gender' => $request->gender,
                'age' => $request->age,
                'height' => $request->height,
                'weight' => $request->weight,
                'fitness_level' => $request->fitness_level,
                'activity_level' => $request->activity_level ?? 'moderately_active',
                'fitness_goals' => $request->fitness_goals,
                'email_verified_at' => null, // Will be set after OTP verification
            ]);

            // Create appropriate profile based on user type
            if ($user->user_type === 'client') {
                ClientProfile::create([
                    'user_id' => $user->id,
                    'status' => 'active',
                    'start_date' => now(),
                    'emergency_contact_name' => null,
                    'emergency_contact_phone' => null,
                    'medical_conditions' => null,
                    'preferred_workout_time' => null,
                ]);
            } elseif ($user->user_type === 'trainer') {
                TrainerProfile::create([
                    'user_id' => $user->id,
                    'specializations' => $request->specializations,
                    'bio' => $request->bio,
                    'years_experience' => $request->years_experience,
                    'hourly_rate' => $request->hourly_rate,
                    'status' => 'pending_approval', // Requires admin approval
                    'accepting_new_clients' => true,
                    'rating' => 0,
                    'total_clients' => 0,
                ]);
            }

            \DB::commit();

            // Log successful registration
            \Log::info('User registration successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'ip' => $request->ip()
            ]);

            // Redirect to OTP verification for clients and trainers only
            if ($user->user_type === 'admin') {
                // Admins skip OTP verification
                $user->update(['email_verified_at' => now()]);
                Auth::login($user);
                return redirect()->route('admin.dashboard')->with('success', 'Admin registration successful!');
            }

            // Redirect to OTP verification page
            return redirect()->route('verify.otp.form', [
                'user_id' => $user->id,
                'email' => $user->email
            ])->with('success', 'Registration successful! Please check your email for the verification code.');

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('User registration failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'registration' => 'Registration failed. Please try again.'
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Show profile completion form
     */
    public function showProfileCompletion()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/login');
        }

        return view('auth.complete-profile', compact('user'));
    }

    /**
     * Handle profile completion
     */
    public function completeProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'user_type' => ['required', 'in:client,trainer'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'height' => ['nullable', 'numeric', 'min:100', 'max:250'],
            'weight' => ['nullable', 'numeric', 'min:30', 'max:300'],
            'activity_level' => ['nullable', 'in:sedentary,lightly_active,moderately_active,very_active,extra_active'],
            'fitness_goal' => ['nullable', 'in:lose_weight,maintain_weight,gain_weight,build_muscle,improve_endurance'],
        ]);

        $user->update($request->only([
            'user_type',
            'date_of_birth',
            'gender', 
            'height',
            'weight',
            'activity_level',
            'fitness_goal'
        ]));

        // Create appropriate profile based on user type
        if ($user->user_type === 'client' && !$user->clientProfile) {
            ClientProfile::create([
                'user_id' => $user->id,
                'experience_level' => 'beginner',
                'status' => 'active',
                'start_date' => now(),
            ]);
        } elseif ($user->user_type === 'trainer' && !$user->trainerProfile) {
            TrainerProfile::create([
                'user_id' => $user->id,
                'status' => 'pending_approval',
                'accepting_new_clients' => true,
            ]);
        }

        return redirect('/dashboard')->with('success', 'Profile completed successfully!');
    }
}
