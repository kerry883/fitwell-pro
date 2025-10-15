<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// Delete existing admin user if exists
$existingAdmin = User::where('email', 'admin@example.com')->first();
if ($existingAdmin) {
    $existingAdmin->delete();
    echo "Existing admin user deleted.\n";
}

// Create an admin user
$admin = User::create([
    'first_name' => 'Admin',
    'last_name' => 'User', 
    'email' => 'admin@example.com',
    'password' => bcrypt('adminpass123'),
    'user_type' => 'admin',
    'email_verified_at' => now()
]);

// Create admin profile
$admin->adminProfile()->create([
    'admin_level' => 'super_admin',
    'department' => 'System Administration',
    'admin_notes' => 'Test admin account',
    'status' => 'active'
]);

echo "Admin user created: " . $admin->email . "\n";