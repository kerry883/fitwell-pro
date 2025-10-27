<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealFood extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'calories_per_100g',
        'protein_per_100g',
        'carbs_per_100g',
        'fats_per_100g',
        'fiber_per_100g',
        'common_serving_size',
        'common_serving_calories',
        'vitamins_minerals',
        'is_verified',
        'created_by',
    ];

    protected $casts = [
        'vitamins_minerals' => 'array',
        'is_verified' => 'boolean',
        'protein_per_100g' => 'decimal:2',
        'carbs_per_100g' => 'decimal:2',
        'fats_per_100g' => 'decimal:2',
        'fiber_per_100g' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
