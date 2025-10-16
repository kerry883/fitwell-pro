<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fitness_history',
        'medical_conditions',
        'injuries',
        'medications',
        'experience_level',
        'preferred_workout_types',
        'available_days_per_week',
        'preferred_workout_time',
        'workout_duration_preference',
        'goals',
        'notes',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'status',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'medical_conditions' => 'array',
            'injuries' => 'array',
            'preferred_workout_types' => 'array',
            'goals' => 'array',
            'preferred_workout_time' => 'datetime:H:i',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(ProgramAssignment::class, 'client_id');
    }
}
