<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'name',
        'description',
        'type',
        'difficulty',
        'duration_minutes',
        'calories_burned',
        'met_value',
        'workout_date',
        'start_time',
        'end_time',
        'status',
        'week_number',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'workout_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
                    ->withPivot(['sets', 'reps', 'weight', 'duration_seconds', 'distance', 'notes', 'order'])
                    ->orderBy('workout_exercises.order');
    }

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class);
    }

    /**
     * Helper methods
     */
    public function getActualDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->end_time->diffInMinutes($this->start_time);
        }
        return null;
    }

    public function getTotalCaloriesBurnedAttribute()
    {
        return $this->workoutExercises()
                    ->join('exercises', 'exercises.id', '=', 'workout_exercises.exercise_id')
                    ->sum('exercises.calories_per_minute') * $this->actual_duration ?? $this->calories_burned;
    }

    /**
     * Calculate calories burned using MET formula
     * Formula: Calories = MET × Weight (kg) × Time (hours)
     */
    public function calculateCaloriesBurned($weightKg = null, $durationHours = null)
    {
        if (!$this->met_value) {
            return $this->calories_burned; // Fallback to stored value
        }

        $weight = $weightKg ?? $this->user->weight ?? 70; // Default to 70kg if no weight available
        $duration = $durationHours ?? ($this->actual_duration ?? $this->duration_minutes) / 60; // Convert to hours

        return round($this->met_value * $weight * $duration);
    }

    /**
     * Get default MET values for different workout types
     */
    public static function getDefaultMetValues()
    {
        return [
            'strength' => 3.0,    // Weight lifting, moderate effort
            'cardio' => 8.0,      // Running, 6 mph
            'flexibility' => 2.3, // Stretching, yoga
            'sports' => 6.0,      // Basketball, soccer
            'other' => 4.0,       // General exercise
        ];
    }
}
