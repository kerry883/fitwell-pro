<?php

namespace App\Models;

use App\Enums\ProgramAssignmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProgramAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'program_id',
        'assigned_date',
        'start_date',
        'end_date',
        'status',
        'current_week',
        'current_session',
        'progress_percentage',
        'customizations',
        'notes',
        'completed_at',
        'approved_at',
        'approved_by',
        'approval_notes',
        'payment_deadline',
        'payment_reminder_sent_at',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'progress_percentage' => 'decimal:2',
        'customizations' => 'array',
        'completed_at' => 'datetime',
        'status' => ProgramAssignmentStatus::class,
        'approved_at' => 'datetime',
        'payment_deadline' => 'datetime',
        'payment_reminder_sent_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, ClientProfile::class, 'id', 'id', 'client_id', 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'program_assignment_id');
    }

    public function getFullNameAttribute()
    {
        return $this->user->full_name ?? 'Unknown User';
    }

    /**
     * Helper methods
     */
    public function isActive(): bool
    {
        return $this->status === ProgramAssignmentStatus::ACTIVE;
    }

    public function isCompleted(): bool
    {
        return $this->status === ProgramAssignmentStatus::COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status === ProgramAssignmentStatus::PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === ProgramAssignmentStatus::REJECTED;
    }

    public function isWithdrawn(): bool
    {
        return $this->status === ProgramAssignmentStatus::WITHDRAWN;
    }

    public function isCancelled(): bool
    {
        return $this->status === ProgramAssignmentStatus::CANCELLED;
    }

    public function canBeDeleted(): bool
    {
        // Only withdrawn, rejected, or cancelled programs can be deleted
        return $this->isWithdrawn() || $this->isRejected() || $this->isCancelled();
    }

    public function isPendingPayment(): bool
    {
        return $this->status === ProgramAssignmentStatus::PENDING_PAYMENT;
    }

    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    public function paymentDeadlineExpired(): bool
    {
        return $this->payment_deadline && now()->gt($this->payment_deadline);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => ProgramAssignmentStatus::COMPLETED,
            'completed_at' => now(),
            'progress_percentage' => 100.00,
        ]);
    }

    public function updateProgress($week, $session, $percentage = null)
    {
        $updates = [
            'current_week' => $week,
            'current_session' => $session,
        ];

        if ($percentage !== null) {
            $updates['progress_percentage'] = $percentage;
        }

        $this->update($updates);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ProgramAssignmentStatus::ACTIVE);
    }

    public function scopePending($query)
    {
        return $query->where('status', ProgramAssignmentStatus::PENDING);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', ProgramAssignmentStatus::REJECTED);
    }

    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }
}
