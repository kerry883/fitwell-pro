<?php

namespace App\Models;

use App\Enums\ProgramCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Program extends Model
{
    use HasFactory;

    protected $casts = [
        'program_category' => ProgramCategory::class,
        'goals' => 'array',
        'dietary_preferences' => 'array',
        'macros_target' => 'array',
        'equipment_required' => 'array',
        'is_public' => 'boolean',
        'includes_meal_prep' => 'boolean',
        'includes_shopping_list' => 'boolean',
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'requires_approval' => 'boolean',
        'auto_approve_criteria' => 'array',
    ];

    protected $fillable = [
        'trainer_id',
        'program_category',
        'program_subtype',
        'name',
        'description',
        'duration_weeks',
        'difficulty_level',
        'sessions_per_week',
        'meals_per_day',
        'goals',
        'dietary_preferences',
        'macros_target',
        'calorie_target',
        'equipment_required',
        'includes_meal_prep',
        'includes_shopping_list',
        'is_public',
        'status',
        'max_clients',
        'current_clients',
        'price',
        'currency',
        'is_free',
        'requires_approval',
        'auto_approve_criteria',
        'payment_deadline_hours',
        'refund_policy_days',
        'notes',
    ];

    /**
     * Relationships
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(TrainerProfile::class, 'trainer_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class);
    }

    public function activeAssignments(): HasMany
    {
        return $this->hasMany(ProgramAssignment::class)->where('status', 'active');
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }

    public function nutritionPlan(): HasOne
    {
        return $this->hasOne(NutritionPlan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Helper methods
     */
    public function isFitnessProgram(): bool
    {
        return $this->program_category === ProgramCategory::FITNESS;
    }

    public function isNutritionProgram(): bool
    {
        return $this->program_category === ProgramCategory::NUTRITION;
    }

    public function getActiveClientsCountAttribute()
    {
        return $this->assignments()->where('status', 'active')->count();
    }

    public function isFull(): bool
    {
        return $this->max_clients && $this->current_clients >= $this->max_clients;
    }

    public function canEnrollClient(): bool
    {
        return !$this->isFull() && $this->status === 'published';
    }

    public function isFree(): bool
    {
        return $this->is_free === true;
    }

    public function requiresApproval(): bool
    {
        return $this->requires_approval !== false;
    }

    /**
     * Currency helper methods
     */
    public function getPriceInKES(): float
    {
        if ($this->currency === 'KES') {
            return (float) $this->price;
        }
        
        // Convert from other currency to KES
        $rate = config('currency.kes_to_usd_rate');
        if ($this->currency === 'USD') {
            return (float) $this->price * $rate;
        }
        
        return (float) $this->price;
    }

    public function getPriceInUSD(): float
    {
        if ($this->currency === 'USD') {
            return (float) $this->price;
        }
        
        // Convert from KES to USD
        $rate = config('currency.kes_to_usd_rate');
        if ($this->currency === 'KES') {
            return (float) $this->price / $rate;
        }
        
        return (float) $this->price;
    }

    public function getFormattedPrice(): string
    {
        $currency = $this->currency ?? config('currency.default');
        $currencyConfig = config("currency.currencies.{$currency}");
        
        if (!$currencyConfig) {
            return number_format($this->price, 2);
        }
        
        $formattedAmount = number_format($this->price, $currencyConfig['decimals']);
        return sprintf($currencyConfig['format'], $formattedAmount);
    }

    public function getCurrencySymbol(): string
    {
        $currency = $this->currency ?? config('currency.default');
        return config("currency.currencies.{$currency}.symbol", '');
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByTrainer($query, $trainerId)
    {
        return $query->where('trainer_id', $trainerId);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFitness($query)
    {
        return $query->where('program_category', ProgramCategory::FITNESS);
    }

    public function scopeNutrition($query)
    {
        return $query->where('program_category', ProgramCategory::NUTRITION);
    }
}
