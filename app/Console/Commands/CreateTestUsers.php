<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test users for development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create test client
        $client = User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'Client',
                'email' => 'client@test.com',
                'password' => Hash::make('password'),
                'user_type' => 'client',
                'email_verified_at' => now(),
                'needs_profile_completion' => false,
            ]
        );

        // Create test trainer
        $trainer = User::updateOrCreate(
            ['email' => 'trainer@test.com'],
            [
                'first_name' => 'Test',
                'last_name' => 'Trainer',
                'email' => 'trainer@test.com',
                'password' => Hash::make('password'),
                'user_type' => 'trainer',
                'email_verified_at' => now(),
                'needs_profile_completion' => false,
            ]
        );

        $this->info('Test users created successfully!');
        $this->info('Client: client@test.com / password');
        $this->info('Trainer: trainer@test.com / password');
    }
}
