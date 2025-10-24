<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'program_id',
        'trainer_id',
        'status',
        'assigned_date',
        'start_date',
        'approved_at',
        'progress_percentage',
        'current_week',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assigned_date' => 'date',
        'start_date' => 'date',
        'approved_at' => 'datetime',
        'progress_percentage' => 'integer',
        'current_week' => 'integer',
    ];

    /**
     * Get the client that owns the assignment.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientProfile::class, 'client_id');
    }

    /**
     * Get the program that owns the assignment.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the trainer that owns the assignment.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(TrainerProfile::class, 'trainer_id');
    }

    /**
     * Get the user associated with the client.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Helper property to get the client's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->user ? $this->user->full_name : 'Unknown Client';
    }
}
