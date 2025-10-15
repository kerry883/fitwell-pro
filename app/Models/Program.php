<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'name',
        'description',
        'duration_weeks',
        'difficulty_level',
        'program_type',
        'sessions_per_week',
        'goals',
        'equipment_required',
        'is_public',
        'status',
        'max_clients',
        'current_clients',
        'price',
        'notes',
    ];

    protected $casts = [
        'goals' => 'array',
        'equipment_required' => 'array',
        'is_public' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(TrainerProfile::class, 'trainer_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class);
    }

    public function activeAssignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class)->where('status', 'active');
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }

    /**
     * Helper methods
     */
    public function getActiveClientsCountAttribute()
    {
        return $this->assignments()->where('status', 'active')->count();
    }

    public function isFull(): bool
    {
        return $this->max_clients && $this->current_clients >= $this->max_clients;
    }

    public function canEnrollClient(): bool
    {
        return !$this->isFull() && $this->status === 'published';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByTrainer($query, $trainerId)
    {
        return $query->where('trainer_id', $trainerId);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
