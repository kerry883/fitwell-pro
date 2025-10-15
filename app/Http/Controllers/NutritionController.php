<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NutritionController extends Controller
{
    /**
     * Display nutrition dashboard.
     */
    public function index()
    {
        // Mock nutrition data
        $nutritionStats = [
            'dailyCalories' => 1850,
            'targetCalories' => 2200,
            'protein' => 95,
            'targetProtein' => 120,
            'carbs' => 210,
            'targetCarbs' => 275,
            'fat' => 68,
            'targetFat' => 73,
            'water' => 2.1,
            'targetWater' => 3.0
        ];

        $recentMeals = [
            [
                'name' => 'Breakfast',
                'time' => '08:00 AM',
                'calories' => 450,
                'items' => ['Oatmeal with berries', 'Greek yogurt', 'Coffee']
            ],
            [
                'name' => 'Lunch',
                'time' => '01:00 PM', 
                'calories' => 650,
                'items' => ['Grilled chicken salad', 'Brown rice', 'Avocado']
            ],
            [
                'name' => 'Snack',
                'time' => '04:00 PM',
                'calories' => 180,
                'items' => ['Protein shake', 'Banana']
            ]
        ];

        $weeklyTrends = [
            'calories' => [1900, 2100, 1850, 2050, 1950, 2200, 1850],
            'protein' => [88, 102, 95, 98, 92, 110, 95],
            'water' => [2.5, 2.8, 2.1, 2.9, 2.3, 3.2, 2.1]
        ];

        return view('nutrition.index', compact('nutritionStats', 'recentMeals', 'weeklyTrends'));
    }

    /**
     * Show meal tracking form.
     */
    public function create()
    {
        $foodDatabase = [
            ['name' => 'Chicken Breast (100g)', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
            ['name' => 'Brown Rice (1 cup)', 'calories' => 216, 'protein' => 5, 'carbs' => 45, 'fat' => 1.8],
            ['name' => 'Broccoli (1 cup)', 'calories' => 25, 'protein' => 3, 'carbs' => 5, 'fat' => 0.3],
            ['name' => 'Greek Yogurt (1 cup)', 'calories' => 130, 'protein' => 23, 'carbs' => 9, 'fat' => 0],
            ['name' => 'Oatmeal (1 cup)', 'calories' => 147, 'protein' => 6, 'carbs' => 27, 'fat' => 2.5],
            ['name' => 'Banana (medium)', 'calories' => 105, 'protein' => 1.3, 'carbs' => 27, 'fat' => 0.4],
            ['name' => 'Avocado (1/2)', 'calories' => 160, 'protein' => 2, 'carbs' => 8.5, 'fat' => 14.7],
        ];

        return view('nutrition.create', compact('foodDatabase'));
    }

    /**
     * Store new meal entry.
     */
    public function store(Request $request)
    {
        // Validation and storage logic would go here
        
        return redirect()->route('nutrition.index')
            ->with('success', 'Meal logged successfully!');
    }
}