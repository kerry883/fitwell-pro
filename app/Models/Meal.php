<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutrition_plan_id',
        'name',
        'meal_type',
        'day_number',
        'meal_time',
        'calories',
        'macros',
        'ingredients',
        'preparation_instructions',
        'prep_time_minutes',
        'recipe_images',
        'alternatives',
        'notes',
    ];

    protected $casts = [
        'macros' => 'array',
        'ingredients' => 'array',
        'recipe_images' => 'array',
        'alternatives' => 'array',
    ];

    protected $attributes = [
        'ingredients' => '[]',
        'recipe_images' => '[]',
        'alternatives' => '[]',
    ];

    /**
     * Relationships
     */
    public function nutritionPlan(): BelongsTo
    {
        return $this->belongsTo(NutritionPlan::class);
    }

    /**
     * Helper methods
     */
    public function getMealTypeLabel(): string
    {
        return match($this->meal_type) {
            'breakfast' => 'Breakfast',
            'morning_snack' => 'Morning Snack',
            'lunch' => 'Lunch',
            'afternoon_snack' => 'Afternoon Snack',
            'dinner' => 'Dinner',
            'evening_snack' => 'Evening Snack',
            default => 'Meal',
        };
    }

    public function getTotalProtein(): float
    {
        return $this->macros['protein'] ?? 0;
    }

    public function getTotalCarbs(): float
    {
        return $this->macros['carbs'] ?? 0;
    }

    public function getTotalFats(): float
    {
        return $this->macros['fats'] ?? 0;
    }

    public function getTotalFiber(): float
    {
        return $this->macros['fiber'] ?? 0;
    }

    public function getMacrosSummary(): string
    {
        return sprintf(
            'P: %dg | C: %dg | F: %dg',
            $this->getTotalProtein(),
            $this->getTotalCarbs(),
            $this->getTotalFats()
        );
    }
}
