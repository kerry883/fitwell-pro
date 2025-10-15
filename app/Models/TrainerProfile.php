<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'certifications',
        'specializations',
        'years_experience',
        'education',
        'approach_description',
        'business_name',
        'business_address',
        'business_phone',
        'business_email',
        'website_url',
        'social_media_links',
        'hourly_rate',
        'package_rates',
        'availability_schedule',
        'max_clients',
        'current_clients',
        'accepting_new_clients',
        'training_locations',
        'cancellation_policy',
        'status',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'specializations' => 'array',
            'social_media_links' => 'array',
            'package_rates' => 'array',
            'availability_schedule' => 'array',
            'training_locations' => 'array',
            'accepting_new_clients' => 'boolean',
            'verified_at' => 'datetime',
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
