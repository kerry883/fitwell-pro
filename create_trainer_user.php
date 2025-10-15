<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Models\TrainerProfile;
use Illuminate\Support\Facades\Hash;

// Load Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Create or update trainer user
$trainer = User::updateOrCreate(
    ['email' => 'trainer@example.com'],
    [
        'first_name' => 'John',
        'last_name' => 'Trainer',
        'email' => 'trainer@example.com',
        'password' => Hash::make('trainerpass123'),
        'user_type' => 'trainer',
        'age' => 32,
        'height' => 180,
        'weight' => 75,
        'fitness_level' => 'advanced',
        'activity_level' => 'very_active',
        'fitness_goals' => ['help_others', 'stay_fit'],
        'email_verified_at' => now(),
    ]
);

// Create or update trainer profile
TrainerProfile::updateOrCreate(
    ['user_id' => $trainer->id],
    [
        'bio' => 'Certified personal trainer with 8+ years of experience helping clients achieve their fitness goals through personalized training programs.',
        'certifications' => [
            'NASM-CPT (National Academy of Sports Medicine)',
            'ACE-CPT (American Council on Exercise)',
            'Precision Nutrition Level 1'
        ],
        'specializations' => [
            'Strength Training',
            'Weight Loss',
            'Functional Movement',
            'Nutrition Coaching'
        ],
        'years_experience' => 8,
        'education' => 'Bachelor of Science in Kinesiology',
        'approach_description' => 'I believe in creating sustainable, enjoyable fitness routines that fit into your lifestyle. My approach combines evidence-based training methods with personalized attention to help you reach your goals safely and effectively.',
        'business_name' => 'FitLife Personal Training',
        'business_address' => '123 Fitness Street, Wellness City, WC 12345',
        'business_phone' => '+1 (555) 123-4567',
        'business_email' => 'john@fitlifept.com',
        'website_url' => 'https://fitlifept.com',
        'social_media_links' => [
            'instagram' => 'https://instagram.com/johntrainerpt',
            'facebook' => 'https://facebook.com/fitlifept'
        ],
        'hourly_rate' => 75.00,
        'package_rates' => null, // Will be set later after fixing the migration
        'availability_schedule' => [
            'Monday' => ['available' => true, 'start_time' => '06:00', 'end_time' => '20:00'],
            'Tuesday' => ['available' => true, 'start_time' => '06:00', 'end_time' => '20:00'],
            'Wednesday' => ['available' => true, 'start_time' => '06:00', 'end_time' => '20:00'],
            'Thursday' => ['available' => true, 'start_time' => '06:00', 'end_time' => '20:00'],
            'Friday' => ['available' => true, 'start_time' => '06:00', 'end_time' => '20:00'],
            'Saturday' => ['available' => true, 'start_time' => '08:00', 'end_time' => '16:00'],
            'Sunday' => ['available' => false, 'start_time' => null, 'end_time' => null]
        ],
        'max_clients' => 25,
        'current_clients' => 12,
        'accepting_new_clients' => true,
        'training_locations' => [
            'Home Studio',
            'Client\'s Home',
            'Local Gym',
            'Outdoor Training'
        ],
        'cancellation_policy' => '24-hour cancellation policy. Sessions cancelled with less than 24 hours notice will be charged 50% of the session fee.',
        'status' => 'active',
        'verified_at' => now(),
    ]
);

echo "✅ Trainer user created successfully!\n";
echo "📧 Email: trainer@example.com\n";
echo "🔑 Password: trainerpass123\n";
echo "👤 Name: {$trainer->full_name}\n";
echo "🏋️ Type: {$trainer->user_type}\n";
echo "💼 Business: {$trainer->trainerProfile->business_name}\n";
echo "\nYou can now log in as a trainer to test the trainer dashboard!\n";