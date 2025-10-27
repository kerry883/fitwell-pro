<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    /**
     * Store a new meal
     */
    public function store(Request $request, $programId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'meal_type' => 'required|in:breakfast,morning_snack,lunch,afternoon_snack,dinner,evening_snack',
            'day_number' => 'required|integer|min:1',
            'meal_time' => 'nullable|string',
            'calories' => 'required|integer|min:0',
            'macros.protein' => 'required|numeric|min:0',
            'macros.carbs' => 'required|numeric|min:0',
            'macros.fats' => 'required|numeric|min:0',
            'macros.fiber' => 'nullable|numeric|min:0',
            'ingredients' => 'nullable|array',
            'ingredients.*.name' => 'nullable|string',
            'ingredients.*.quantity' => 'nullable|numeric',
            'ingredients.*.unit' => 'nullable|string',
            'preparation_instructions' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'recipe_images' => 'nullable|array',
            'alternatives' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        // Filter out empty ingredients (where name is empty)
        if (isset($validated['ingredients'])) {
            $validated['ingredients'] = array_filter($validated['ingredients'], function($ingredient) {
                return !empty($ingredient['name']);
            });
            // Re-index array to avoid gaps
            $validated['ingredients'] = array_values($validated['ingredients']);
        }

        // Ensure required fields have default values if not provided
        $validated['ingredients'] = $validated['ingredients'] ?? [];
        $validated['recipe_images'] = $validated['recipe_images'] ?? [];
        $validated['alternatives'] = $validated['alternatives'] ?? [];

        $program->nutritionPlan->meals()->create($validated);

        return back()->with('success', 'Meal added successfully!');
    }

    /**
     * Update a meal
     */
    public function update(Request $request, $programId, $mealId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $meal = $program->nutritionPlan->meals()->findOrFail($mealId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'meal_type' => 'required|in:breakfast,morning_snack,lunch,afternoon_snack,dinner,evening_snack',
            'day_number' => 'required|integer|min:1',
            'meal_time' => 'nullable|string',
            'calories' => 'required|integer|min:0',
            'macros.protein' => 'required|numeric|min:0',
            'macros.carbs' => 'required|numeric|min:0',
            'macros.fats' => 'required|numeric|min:0',
            'macros.fiber' => 'nullable|numeric|min:0',
            'ingredients' => 'nullable|array',
            'ingredients.*.name' => 'nullable|string',
            'ingredients.*.quantity' => 'nullable|numeric',
            'ingredients.*.unit' => 'nullable|string',
            'preparation_instructions' => 'nullable|string',
            'prep_time_minutes' => 'nullable|integer|min:0',
            'recipe_images' => 'nullable|array',
            'alternatives' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        // Filter out empty ingredients (where name is empty)
        if (isset($validated['ingredients'])) {
            $validated['ingredients'] = array_filter($validated['ingredients'], function($ingredient) {
                return !empty($ingredient['name']);
            });
            // Re-index array to avoid gaps
            $validated['ingredients'] = array_values($validated['ingredients']);
        }

        // Ensure required fields have default values if not provided
        $validated['ingredients'] = $validated['ingredients'] ?? [];
        $validated['recipe_images'] = $validated['recipe_images'] ?? [];
        $validated['alternatives'] = $validated['alternatives'] ?? [];

        $meal->update($validated);

        return back()->with('success', 'Meal updated successfully!');
    }

    /**
     * Delete a meal
     */
    public function destroy($programId, $mealId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $meal = $program->nutritionPlan->meals()->findOrFail($mealId);
        $meal->delete();

        return back()->with('success', 'Meal deleted successfully!');
    }

    /**
     * Duplicate meal to another day
     */
    public function duplicate(Request $request, $programId, $mealId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $meal = $program->nutritionPlan->meals()->findOrFail($mealId);

        $validated = $request->validate([
            'day_number' => 'required|integer|min:1',
        ]);

        $newMeal = $meal->replicate();
        $newMeal->day_number = $validated['day_number'];
        $newMeal->save();

        return back()->with('success', 'Meal duplicated successfully!');
    }
}
