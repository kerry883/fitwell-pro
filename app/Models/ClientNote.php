<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trainer_id',
        'title',
        'content',
        'type',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    const TYPES = [
        'general' => 'General Note',
        'progress' => 'Progress Update',
        'concern' => 'Concern',
        'achievement' => 'Achievement',
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Accessors
     */
    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? 'General Note';
    }
}
