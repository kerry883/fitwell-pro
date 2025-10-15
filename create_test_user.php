<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// Create a test user
$user = User::create([
    'first_name' => 'Test',
    'last_name' => 'User', 
    'email' => 'test@example.com',
    'password' => bcrypt('password123'),
    'user_type' => 'client',
    'email_verified_at' => now()
]);

$user->clientProfile()->create([
    'fitness_level' => 'beginner',
    'primary_goal' => 'lose_weight'
]);

echo "Test user created: " . $user->email . "\n";