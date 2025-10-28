<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Display progress tracking dashboard.
     */
    public function index()
    {
        // Mock progress data
        $progressStats = [
            'currentWeight' => 75.2,
            'goalWeight' => 70.0,
            'weightChange' => -2.3,
            'bodyFat' => 15.5,
            'muscleMass' => 45.8,
            'bmi' => 22.1
        ];

        $measurements = [
            ['date' => '2024-01-15', 'weight' => 77.5, 'body_fat' => 16.2, 'muscle_mass' => 45.1],
            ['date' => '2024-01-22', 'weight' => 76.8, 'body_fat' => 15.9, 'muscle_mass' => 45.3],
            ['date' => '2024-01-29', 'weight' => 75.9, 'body_fat' => 15.7, 'muscle_mass' => 45.6],
            ['date' => '2024-02-05', 'weight' => 75.2, 'body_fat' => 15.5, 'muscle_mass' => 45.8],
        ];

        $workoutProgress = [
            'totalWorkouts' => 48,
            'thisMonth' => 12,
            'averageDuration' => 42,
            'totalCaloriesBurned' => 15420,
            'personalRecords' => [
                ['exercise' => 'Bench Press', 'weight' => '80kg', 'date' => '2024-02-01'],
                ['exercise' => 'Squat', 'weight' => '100kg', 'date' => '2024-01-28'],
                ['exercise' => 'Deadlift', 'weight' => '120kg', 'date' => '2024-01-25'],
            ]
        ];

        $goals = [
            [
                'name' => 'Lose 5kg',
                'current' => 2.3,
                'target' => 5.0,
                'progress' => 46,
                'deadline' => '2024-06-01'
            ],
            [
                'name' => '100 Push-ups',
                'current' => 65,
                'target' => 100,
                'progress' => 65,
                'deadline' => '2024-04-01'
            ],
            [
                'name' => '5K Run under 25min',
                'current' => 27.5,
                'target' => 25.0,
                'progress' => 83,
                'deadline' => '2024-05-01'
            ]
        ];

        return view('progress.index', compact('progressStats', 'measurements', 'workoutProgress', 'goals'));
    }

    /**
     * Show form to add new measurement.
     */
    public function create()
    {
        return view('progress.create');
    }

    /**
     * Store new measurement.
     */
    public function store(Request $request)
    {
        // Validation and storage logic would go here
        
        return redirect()->route('progress.index')
            ->with('success', 'Measurement recorded successfully!');
    }
}