<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
        'difficulty',
        'duration_minutes',
        'calories_burned',
        'workout_date',
        'start_time',
        'end_time',
        'status',
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
}
