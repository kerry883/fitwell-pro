<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoalTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'client_id',
        'value',
        'unit',
        'tracking_date',
        'notes',
        'entry_type',
        'metadata',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'tracking_date' => 'date',
        'metadata' => 'array',
    ];

    const ENTRY_TYPES = [
        'manual' => 'Manual Entry',
        'automatic' => 'Automatic',
        'measurement' => 'Body Measurement',
        'workout' => 'Workout Result',
        'assessment' => 'Assessment',
    ];

    /**
     * Relationships
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    /**
     * Scopes
     */
    public function scopeForGoal($query, $goalId)
    {
        return $query->where('goal_id', $goalId);
    }

    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tracking_date', [$startDate, $endDate]);
    }

    public function scopeByEntryType($query, $type)
    {
        return $query->where('entry_type', $type);
    }

    /**
     * Accessors
     */
    public function getEntryTypeLabelAttribute()
    {
        return self::ENTRY_TYPES[$this->entry_type] ?? 'Manual Entry';
    }

    public function getFormattedValueAttribute()
    {
        if ($this->unit) {
            return $this->value . ' ' . $this->unit;
        }
        return $this->value;
    }

    /**
     * Methods
     */
    public function getPreviousEntry()
    {
        return self::where('goal_id', $this->goal_id)
            ->where('tracking_date', '<', $this->tracking_date)
            ->orderBy('tracking_date', 'desc')
            ->first();
    }

    public function getNextEntry()
    {
        return self::where('goal_id', $this->goal_id)
            ->where('tracking_date', '>', $this->tracking_date)
            ->orderBy('tracking_date')
            ->first();
    }

    public function calculateChange()
    {
        $previous = $this->getPreviousEntry();
        if ($previous) {
            return $this->value - $previous->value;
        }
        return null;
    }
}
