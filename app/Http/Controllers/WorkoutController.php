<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * Display a listing of workouts.
     */
    public function index()
    {
        // Mock data for workouts
        $workouts = [
            [
                'id' => 1,
                'name' => 'Upper Body Strength',
                'category' => 'Strength',
                'duration' => 45,
                'calories' => 285,
                'difficulty' => 'Intermediate',
                'equipment' => 'Dumbbells, Bench',
                'created_at' => now()->subDays(1)
            ],
            [
                'id' => 2,
                'name' => 'Morning Cardio',
                'category' => 'Cardio',
                'duration' => 30,
                'calories' => 165,
                'difficulty' => 'Beginner',
                'equipment' => 'None',
                'created_at' => now()->subDays(2)
            ],
            [
                'id' => 3,
                'name' => 'Leg Day',
                'category' => 'Strength',
                'duration' => 60,
                'calories' => 420,
                'difficulty' => 'Advanced',
                'equipment' => 'Barbell, Plates',
                'created_at' => now()->subDays(3)
            ]
        ];

        return view('workouts.index', compact('workouts'));
    }

    /**
     * Show the form for creating a new workout.
     */
    public function create()
    {
        return view('workouts.create');
    }

    /**
     * Store a newly created workout.
     */
    public function store(Request $request)
    {
        // Validation would go here
        // For now, just redirect back with success message
        
        return redirect()->route('workouts.index')
            ->with('success', 'Workout created successfully!');
    }

    /**
     * Display the specified workout.
     */
    public function show($id)
    {
        // Mock workout data
        $workout = [
            'id' => $id,
            'name' => 'Upper Body Strength',
            'category' => 'Strength',
            'duration' => 45,
            'calories' => 285,
            'difficulty' => 'Intermediate',
            'equipment' => 'Dumbbells, Bench',
            'description' => 'A comprehensive upper body workout focusing on chest, back, shoulders, and arms.',
            'exercises' => [
                ['name' => 'Bench Press', 'sets' => 3, 'reps' => '8-10', 'rest' => '90s'],
                ['name' => 'Bent-Over Rows', 'sets' => 3, 'reps' => '8-10', 'rest' => '90s'],
                ['name' => 'Shoulder Press', 'sets' => 3, 'reps' => '10-12', 'rest' => '60s'],
                ['name' => 'Bicep Curls', 'sets' => 3, 'reps' => '10-12', 'rest' => '60s'],
                ['name' => 'Tricep Extensions', 'sets' => 3, 'reps' => '10-12', 'rest' => '60s'],
            ]
        ];

        return view('workouts.show', compact('workout'));
    }

    /**
     * Show the form for editing the specified workout.
     */
    public function edit($id)
    {
        // Mock workout data for editing
        $workout = [
            'id' => $id,
            'name' => 'Upper Body Strength',
            'category' => 'Strength',
            'duration' => 45,
            'difficulty' => 'Intermediate',
            'equipment' => 'Dumbbells, Bench',
            'description' => 'A comprehensive upper body workout focusing on chest, back, shoulders, and arms.'
        ];

        return view('workouts.edit', compact('workout'));
    }

    /**
     * Update the specified workout.
     */
    public function update(Request $request, $id)
    {
        // Validation and update logic would go here
        
        return redirect()->route('workouts.show', $id)
            ->with('success', 'Workout updated successfully!');
    }

    /**
     * Remove the specified workout.
     */
    public function destroy($id)
    {
        // Delete logic would go here
        
        return redirect()->route('workouts.index')
            ->with('success', 'Workout deleted successfully!');
    }
}