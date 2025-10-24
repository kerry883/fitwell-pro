<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'trainer_count',
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
        'joined_date',
        'last_session',
        'next_session',
        'progress',
        'sessions_completed',
        'waist_cm',
        'chest_cm',
        'arms_cm',
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
            'joined_date' => 'date',
            'last_session' => 'date',
            'next_session' => 'datetime',
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

    public function notes()
    {
        return $this->hasMany(ClientNote::class, 'client_id');
    }

    public function schedules()
    {
        return $this->hasMany(ClientSchedule::class, 'client_id');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class, 'client_id');
    }
}
