<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'food_name',
        'quantity',
        'unit',
        'calories',
        'protein',
        'carbohydrates',
        'fat',
        'fiber',
        'sugar',
        'meal_type',
        'consumed_date',
        'consumed_time',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'consumed_date' => 'date',
            'consumed_time' => 'datetime:H:i',
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
