<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;

    protected $casts = [
        'preferred_workout_types' => 'array',
        'equipment_access' => 'array',
        'medical_conditions' => 'array',
        'onboarding_completed' => 'boolean',
        'onboarding_completed_at' => 'datetime',
        'medical_clearance' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'trainer_id',
        'trainer_count',
        'fitness_history',
        'medical_conditions',
        'injuries',
        'medications',
        'medical_notes',
        'medical_clearance',
        'experience_level',
        'preferred_workout_types',
        'available_days_per_week',
        'preferred_workout_time',
        'workout_duration_preference',
        'equipment_access',
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
        'onboarding_completed',
        'onboarding_completed_at',
        'onboarding_step',
        // Note: 'goals' field removed - use goals relationship instead
    ];

    protected function casts(): array
    {
        return [
            // Cast definitions moved to property $casts above
            'injuries' => 'array',
            'preferred_workout_types' => 'array',
            // Note: 'goals' removed - stored in goals_deprecated field, use goals relationship
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

    /**
     * Onboarding helper methods
     */
    public function hasCompletedOnboarding(): bool
    {
        return $this->onboarding_completed === true;
    }

    public function getCurrentOnboardingStep(): int
    {
        return $this->onboarding_step ?? 0;
    }

    public function markOnboardingStep(int $step): void
    {
        $this->update(['onboarding_step' => $step]);
    }

    public function completeOnboarding(): void
    {
        $this->update([
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
            'onboarding_step' => 7, // Total steps
        ]);
    }

    public function hasActiveGoals(): bool
    {
        return $this->goals()
            ->where('type', 'client_set')
            ->where('is_active_for_matching', true)
            ->where('status', 'active')
            ->exists();
    }
}
