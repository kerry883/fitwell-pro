<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'date_of_birth' => '1990-05-15',
            'gender' => 'male',
            'height' => 175.5,
            'weight' => 75.0,
            'activity_level' => 'moderately_active',
            'fitness_goal' => 'build_muscle',
            'preferences' => [
                'notifications' => true,
                'public_profile' => false,
                'metric_units' => true
            ]
        ]);

        \App\Models\User::create([
            'name' => 'Sarah Wilson',
            'email' => 'sarah@example.com',
            'password' => bcrypt('password'),
            'date_of_birth' => '1985-08-22',
            'gender' => 'female',
            'height' => 165.0,
            'weight' => 62.5,
            'activity_level' => 'very_active',
            'fitness_goal' => 'lose_weight',
            'preferences' => [
                'notifications' => true,
                'public_profile' => true,
                'metric_units' => true
            ]
        ]);

        \App\Models\User::create([
            'name' => 'Mike Johnson',
            'email' => 'mike@example.com',
            'password' => bcrypt('password'),
            'date_of_birth' => '1988-12-03',
            'gender' => 'male',
            'height' => 180.0,
            'weight' => 85.0,
            'activity_level' => 'lightly_active',
            'fitness_goal' => 'improve_endurance',
            'preferences' => [
                'notifications' => false,
                'public_profile' => true,
                'metric_units' => true
            ]
        ]);
    }
}
