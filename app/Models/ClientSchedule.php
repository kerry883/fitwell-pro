<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ClientSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trainer_id',
        'scheduled_date',
        'start_time',
        'end_time',
        'session_type',
        'location',
        'notes',
        'status',
        'completed_at',
        'actual_duration_minutes',
        'performance_rating',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'completed_at' => 'datetime',
        'performance_rating' => 'integer',
        'actual_duration_minutes' => 'integer',
    ];

    const STATUSES = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'missed' => 'Missed',
    ];

    const SESSION_TYPES = [
        'training' => 'Training Session',
        'consultation' => 'Consultation',
        'assessment' => 'Assessment',
        'check_in' => 'Check-in',
    ];

    /**
     * Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Scopes
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeByTrainer($query, $trainerId)
    {
        return $query->where('trainer_id', $trainerId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', now()->toDateString())
                    ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_date', '<', now()->toDateString())
                    ->orWhere(function($q) {
                        $q->where('scheduled_date', now()->toDateString())
                          ->where('end_time', '<', now()->toTimeString());
                    });
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? 'Unknown';
    }

    public function getSessionTypeLabelAttribute()
    {
        return self::SESSION_TYPES[$this->session_type] ?? 'Training Session';
    }

    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_date > now()->toDateString() ||
               ($this->scheduled_date == now()->toDateString() && $this->start_time > now());
    }

    public function getIsPastAttribute()
    {
        return !$this->is_upcoming;
    }

    public function getDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->diffInMinutes($this->end_time);
        }
        return null;
    }

    /**
     * Methods
     */
    public function markAsCompleted($actualDuration = null, $rating = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'actual_duration_minutes' => $actualDuration,
            'performance_rating' => $rating,
        ]);
    }

    public function markAsMissed()
    {
        $this->update(['status' => 'missed']);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
