<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display the calendar view.
     */
    public function index()
    {
        // Mock calendar events
        $events = [
            [
                'id' => 1,
                'title' => 'Upper Body Workout',
                'start' => now()->addDays(1)->setTime(18, 0)->toDateString() . 'T18:00:00',
                'end' => now()->addDays(1)->setTime(19, 0)->toDateString() . 'T19:00:00',
                'backgroundColor' => '#10b981',
                'borderColor' => '#059669',
                'extendedProps' => [
                    'type' => 'workout',
                    'duration' => 60,
                    'calories' => 300
                ]
            ],
            [
                'id' => 2,
                'title' => 'Morning Cardio',
                'start' => now()->addDays(2)->setTime(7, 0)->toDateString() . 'T07:00:00',
                'end' => now()->addDays(2)->setTime(8, 0)->toDateString() . 'T08:00:00',
                'backgroundColor' => '#f59e0b',
                'borderColor' => '#d97706',
                'extendedProps' => [
                    'type' => 'workout',
                    'duration' => 60,
                    'calories' => 200
                ]
            ],
            [
                'id' => 3,
                'title' => 'Meal Prep',
                'start' => now()->addDays(0)->setTime(10, 0)->toDateString() . 'T10:00:00',
                'end' => now()->addDays(0)->setTime(12, 0)->toDateString() . 'T12:00:00',
                'backgroundColor' => '#06b6d4',
                'borderColor' => '#0891b2',
                'extendedProps' => [
                    'type' => 'nutrition',
                    'duration' => 120,
                    'notes' => 'Prepare meals for the week'
                ]
            ],
            [
                'id' => 4,
                'title' => 'Yoga Session',
                'start' => now()->addDays(3)->setTime(19, 0)->toDateString() . 'T19:00:00',
                'end' => now()->addDays(3)->setTime(20, 30)->toDateString() . 'T20:30:00',
                'backgroundColor' => '#8b5cf6',
                'borderColor' => '#7c3aed',
                'extendedProps' => [
                    'type' => 'workout',
                    'duration' => 90,
                    'calories' => 150
                ]
            ],
            [
                'id' => 5,
                'title' => 'Progress Check',
                'start' => now()->addDays(6)->setTime(9, 0)->toDateString() . 'T09:00:00',
                'end' => now()->addDays(6)->setTime(9, 30)->toDateString() . 'T09:30:00',
                'backgroundColor' => '#ef4444',
                'borderColor' => '#dc2626',
                'extendedProps' => [
                    'type' => 'measurement',
                    'duration' => 30,
                    'notes' => 'Weekly weigh-in and measurements'
                ]
            ]
        ];

        return view('calendar.index', compact('events'));
    }

    /**
     * Store a new calendar event.
     */
    public function store(Request $request)
    {
        // Validation and storage logic would go here
        
        return response()->json([
            'success' => true,
            'message' => 'Event created successfully!'
        ]);
    }

    /**
     * Update an existing calendar event.
     */
    public function update(Request $request, $id)
    {
        // Update logic would go here
        
        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully!'
        ]);
    }

    /**
     * Delete a calendar event.
     */
    public function destroy($id)
    {
        // Delete logic would go here
        
        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!'
        ]);
    }
}