<?php

namespace App\Services;

use App\Models\User;
use App\Models\ClientProfile;
use App\Models\TrainerProfile;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function registerUser(array $data)
    {
        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'user_type' => $data['user_type'],
                'gender' => $data['gender'] ?? null,
                'age' => $data['age'] ?? null,
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
                'fitness_level' => $data['fitness_level'] ?? null,
                'activity_level' => $data['activity_level'] ?? 'moderately_active',
                'fitness_goals' => $data['fitness_goals'] ?? null,
            ]);

            // Create profile based on user type
            if ($user->user_type === 'client') {
                $this->createClientProfile($user, $data);
            } elseif ($user->user_type === 'trainer') {
                $this->createTrainerProfile($user, $data);
            }

            DB::commit();

            // Log successful registration
            Log::info('User registration successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type,
                'ip' => request()->ip()
            ]);

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'email' => $data['email'],
                'ip' => request()->ip()
            ]);

            throw $e;
        }
    }

    protected function createClientProfile(User $user, array $data)
    {
        ClientProfile::create([
            'user_id' => $user->id,
            'status' => 'active',
            'start_date' => now(),
            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            'medical_conditions' => $data['medical_conditions'] ?? null,
            'preferred_workout_time' => $data['preferred_workout_time'] ?? null,
        ]);
    }

    protected function createTrainerProfile(User $user, array $data)
    {
        TrainerProfile::create([
            'user_id' => $user->id,
            'specializations' => $data['specializations'] ?? null,
            'bio' => $data['bio'] ?? null,
            'years_experience' => $data['years_experience'] ?? null,
            'hourly_rate' => $data['hourly_rate'] ?? null,
            'status' => 'pending_approval',
            'accepting_new_clients' => true,
            'rating' => 0,
            'total_clients' => 0,
        ]);
    }
}