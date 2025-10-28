<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'program_assignment_id',
        'program_id',
        'trainer_id',
        'amount',
        'currency',
        'payment_type',
        'payment_method',
        'stripe_payment_intent_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'status',
        'paid_at',
        'refunded_at',
        'refund_amount',
        'refund_reason',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user who made the payment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program assignment associated with the payment.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ProgramAssignment::class, 'program_assignment_id');
    }

    /**
     * Get the program associated with the payment.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the trainer who receives the payment.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Check if the payment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the payment has failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if the payment has been refunded.
     */
    public function isRefunded(): bool
    {
        return $this->status === 'refunded';
    }

    /**
     * Check if the payment is eligible for refund.
     */
    public function canRefund(): bool
    {
        if (!$this->isCompleted() || $this->isRefunded()) {
            return false;
        }

        if (!$this->program) {
            return false;
        }

        $refundDeadline = $this->paid_at->addDays($this->program->refund_policy_days ?? 7);
        return now()->lte($refundDeadline);
    }
}
