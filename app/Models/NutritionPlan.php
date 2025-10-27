<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class NutritionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'name',
        'description',
        'total_calories',
        'macros',
        'meal_timing',
        'supplements',
        'general_guidelines',
        'hydration_goal',
    ];

    protected $casts = [
        'macros' => 'array',
        'meal_timing' => 'array',
        'supplements' => 'array',
    ];

    /**
     * Relationships
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Helper methods
     */
    public function getMealsByDay(int $day): Collection
    {
        return $this->meals()
            ->where('day_number', $day)
            ->orderBy('meal_time')
            ->get();
    }

    public function getTotalDailyCalories(int $day): int
    {
        return $this->meals()
            ->where('day_number', $day)
            ->sum('calories');
    }

    public function getMealsByType(string $mealType): Collection
    {
        return $this->meals()
            ->where('meal_type', $mealType)
            ->orderBy('day_number')
            ->get();
    }
}
