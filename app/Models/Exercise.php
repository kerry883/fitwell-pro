<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'muscle_groups',
        'equipment_needed',
        'instructions',
        'calories_per_minute',
        'video_url',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'muscle_groups' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises')
                    ->withPivot(['sets', 'reps', 'weight', 'duration_seconds', 'distance', 'notes', 'order']);
    }

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class);
    }
}
