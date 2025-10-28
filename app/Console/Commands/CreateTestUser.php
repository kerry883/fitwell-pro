<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test client user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'Client',
                'email' => 'client@test.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'gender' => 'male',
                'age' => 25,
                'height' => 175,
                'weight' => 70,
                'fitness_level' => 'beginner',
                'activity_level' => 'moderate',
                'fitness_goals' => json_encode(['weight_loss', 'muscle_gain']),
                'preferences' => json_encode([]),
                'needs_profile_completion' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->info('Test client user created with email: client@test.com and password: password');

        // Create some test notifications
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'program_assignment_approved',
            'title' => 'Program Assignment Approved',
            'message' => 'Your program assignment has been approved by your trainer. You can now start your fitness journey!',
            'data' => json_encode(['program_id' => 1]),
            'is_read' => false,
            'created_at' => now()->subHours(2),
            'updated_at' => now()->subHours(2),
        ]);

        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'enrollment_request',
            'title' => 'New Enrollment Request',
            'message' => 'You have a new enrollment request from a trainer. Please review and respond.',
            'data' => json_encode(['trainer_id' => 1]),
            'is_read' => true,
            'created_at' => now()->subHours(1),
            'updated_at' => now()->subHours(1),
        ]);

        \App\Models\Notification::create([
            'user_id' => $user->id,
            'type' => 'program_completed',
            'title' => 'Congratulations! Program Completed',
            'message' => 'You have successfully completed your fitness program. Great job on your dedication and hard work!',
            'data' => json_encode(['program_id' => 2]),
            'is_read' => false,
            'created_at' => now()->subMinutes(30),
            'updated_at' => now()->subMinutes(30),
        ]);

        $this->info('Created 3 test notifications for the user');
        
        return Command::SUCCESS;
    }
}
