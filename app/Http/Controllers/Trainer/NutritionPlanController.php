<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionPlanController extends Controller
{
    /**
     * Display nutrition plan for a program
     */
    public function show($programId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)
            ->with(['nutritionPlan.meals' => function($query) {
                $query->orderBy('day_number')->orderBy('meal_time');
            }])
            ->findOrFail($programId);

        if (!$program->isNutritionProgram()) {
            return redirect()->route('trainer.programs.show', $programId)
                ->with('error', 'This is not a nutrition program.');
        }

        return view('trainer.nutrition-plans.show', compact('program'));
    }

    /**
     * Update nutrition plan details
     */
    public function update(Request $request, $programId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->isNutritionProgram() || !$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_calories' => 'nullable|integer|min:500',
            'macros.protein' => 'nullable|integer|min:0',
            'macros.carbs' => 'nullable|integer|min:0',
            'macros.fats' => 'nullable|integer|min:0',
            'macros.fiber' => 'nullable|integer|min:0',
            'meal_timing' => 'nullable|array',
            'supplements' => 'nullable|array',
            'general_guidelines' => 'nullable|string',
            'hydration_goal' => 'nullable|string',
        ]);

        $program->nutritionPlan->update($validated);

        return back()->with('success', 'Nutrition plan updated successfully!');
    }

    /**
     * Delete nutrition plan (and all its meals)
     */
    public function destroy($programId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        if (!$program->nutritionPlan) {
            return back()->with('error', 'Nutrition plan not found.');
        }

        $program->nutritionPlan->delete();

        return redirect()->route('trainer.programs.show', $programId)
            ->with('success', 'Nutrition plan deleted successfully!');
    }
}
