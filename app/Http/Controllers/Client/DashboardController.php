<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index()
    {
        // Here you would typically fetch user data, recent workouts, progress metrics, etc.
        // For now, we'll return the view with static data
        
        $stats = [
            'todayWorkouts' => 2,
            'caloriesBurned' => 450,
            'weeklyGoalProgress' => 68,
            'currentStreak' => 12,
        ];

        $recentWorkouts = [
            [
                'name' => 'Upper Body Strength',
                'date' => 'Today',
                'duration' => 45,
                'calories' => 285,
                'completed' => true
            ],
            [
                'name' => 'Morning Cardio',
                'date' => 'Yesterday', 
                'duration' => 30,
                'calories' => 165,
                'completed' => true
            ],
            [
                'name' => 'Leg Day',
                'date' => '2 days ago',
                'duration' => 60,
                'calories' => 420,
                'completed' => true
            ]
        ];

        $todaySchedule = [
            [
                'time' => '07:00 AM',
                'activity' => 'Morning Cardio',
                'status' => 'completed'
            ],
            [
                'time' => '12:00 PM',
                'activity' => 'Protein Shake',
                'status' => 'completed'
            ],
            [
                'time' => '06:00 PM',
                'activity' => 'Strength Training',
                'status' => 'upcoming'
            ],
            [
                'time' => '08:00 PM',
                'activity' => 'Post-workout meal',
                'status' => 'upcoming'
            ]
        ];

        return view('client.dashboard', compact('stats', 'recentWorkouts', 'todaySchedule'));
    }
}
