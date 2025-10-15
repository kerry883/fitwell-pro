<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'value',
        'unit',
        'body_part',
        'photo_url',
        'log_date',
        'notes',
        'additional_data',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'additional_data' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
