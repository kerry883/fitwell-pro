<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trainer_id',
        'title',
        'description',
        'category',
        'type',
        'measurement_type',
        'target_value',
        'target_unit',
        'current_value',
        'target_date',
        'start_date',
        'status',
        'priority',
        'notes',
        'milestones',
        'is_active_for_matching',
        'medical_considerations',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'current_value' => 'decimal:2',
        'target_date' => 'date',
        'start_date' => 'date',
        'priority' => 'integer',
        'milestones' => 'array',
        'is_active_for_matching' => 'boolean',
        'medical_considerations' => 'array',
    ];

    const CATEGORIES = [
        'weight_loss' => 'Weight Loss',
        'weight_gain' => 'Weight Gain',
        'muscle_building' => 'Muscle Building',
        'strength' => 'Strength',
        'endurance' => 'Endurance',
        'flexibility' => 'Flexibility',
        'general_fitness' => 'General Fitness',
        'sports_performance' => 'Sports Performance',
        'health_improvement' => 'Health Improvement',
        'other' => 'Other',
    ];

    const TYPES = [
        'client_set' => 'Client-Defined Goal',
        'trainer_set' => 'Trainer-Defined Goal',
        'program_based' => 'Program-Based Goal',
        'milestone' => 'Achievement Milestone',
    ];

    const MEASUREMENT_TYPES = [
        'weight' => 'Weight',
        'body_fat' => 'Body Fat %',
        'muscle_mass' => 'Muscle Mass',
        'measurements' => 'Body Measurements',
        'performance' => 'Performance Metrics',
        'time_based' => 'Time Based',
        'repetition_based' => 'Repetition Based',
        'distance_based' => 'Distance Based',
        'custom' => 'Custom',
    ];

    const STATUSES = [
        'active' => 'Active',
        'completed' => 'Completed',
        'paused' => 'Paused',
        'cancelled' => 'Cancelled',
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

    public function trackings(): HasMany
    {
        return $this->hasMany(GoalTracking::class)->orderBy('tracking_date', 'desc');
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Accessors
     */
    public function getCategoryLabelAttribute()
    {
        return self::CATEGORIES[$this->category] ?? 'Other';
    }

    public function getTypeLabelAttribute()
    {
        return self::TYPES[$this->type] ?? 'Primary Goal';
    }

    public function getMeasurementTypeLabelAttribute()
    {
        return self::MEASUREMENT_TYPES[$this->measurement_type] ?? 'Custom';
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? 'Active';
    }

    public function getProgressPercentageAttribute()
    {
        if (!$this->target_value || !$this->current_value) {
            return 0;
        }

        // For weight loss, progress is inverse
        if (in_array($this->category, ['weight_loss', 'body_fat'])) {
            if ($this->start_value && $this->start_value > $this->target_value) {
                $totalChange = $this->start_value - $this->target_value;
                $currentChange = $this->start_value - $this->current_value;
                return min(100, max(0, ($currentChange / $totalChange) * 100));
            }
        }

        // For other goals, progress is direct
        if ($this->target_value > 0) {
            return min(100, max(0, ($this->current_value / $this->target_value) * 100));
        }

        return 0;
    }

    public function getDaysRemainingAttribute()
    {
        if (!$this->target_date) {
            return null;
        }

        return max(0, Carbon::now()->diffInDays($this->target_date, false));
    }

    public function getIsOverdueAttribute()
    {
        return $this->target_date && $this->target_date < now() && $this->status === 'active';
    }

    public function getLatestTrackingAttribute()
    {
        return $this->trackings()->first();
    }

    /**
     * Methods
     */
    public function updateProgress($value, $date = null, $notes = null)
    {
        $trackingDate = $date ? Carbon::parse($date) : now();

        // Update current value
        $this->current_value = $value;
        $this->save();

        // Create tracking entry
        return $this->trackings()->create([
            'client_id' => $this->client_id,
            'value' => $value,
            'unit' => $this->target_unit,
            'tracking_date' => $trackingDate,
            'notes' => $notes,
            'entry_type' => 'manual',
        ]);
    }

    /**
     * Check for medical considerations before goal creation
     */
    public function checkMedicalConsiderations($clientProfile)
    {
        $warnings = [];

        // Check for medical conditions that might affect goal setting
        $medicalConditions = $clientProfile->medical_conditions ?? [];
        $injuries = $clientProfile->injuries ?? [];

        // Weight loss goals with certain conditions
        if ($this->category === 'weight_loss') {
            if (in_array('eating_disorder', $medicalConditions) ||
                in_array('anorexia', $medicalConditions) ||
                in_array('bulimia', $medicalConditions)) {
                $warnings[] = 'Client has history of eating disorders. Weight loss goals should be approached with extreme caution and medical supervision.';
            }

            if (in_array('diabetes', $medicalConditions)) {
                $warnings[] = 'Client has diabetes. Weight loss should be gradual (0.5-1kg per week) and coordinated with healthcare provider.';
            }

            if ($clientProfile->weight_kg && $clientProfile->height_cm) {
                $bmi = $clientProfile->weight_kg / (($clientProfile->height_cm / 100) ** 2);
                if ($bmi < 18.5) {
                    $warnings[] = 'Client has low BMI. Weight loss goals may not be appropriate.';
                }
            }
        }

        // Strength/muscle building goals with injuries
        if (in_array($this->category, ['strength', 'muscle_building'])) {
            $upperBodyInjuries = array_filter($injuries, function($injury) {
                return stripos($injury, 'shoulder') !== false ||
                       stripos($injury, 'arm') !== false ||
                       stripos($injury, 'back') !== false;
            });

            if (!empty($upperBodyInjuries)) {
                $warnings[] = 'Client has upper body injuries. Strength training should be modified and supervised.';
            }
        }

        // Cardiovascular goals with heart conditions
        if (in_array($this->category, ['endurance', 'cardio'])) {
            if (in_array('heart_disease', $medicalConditions) ||
                in_array('hypertension', $medicalConditions) ||
                in_array('arrhythmia', $medicalConditions)) {
                $warnings[] = 'Client has cardiovascular conditions. Exercise intensity should be cleared by cardiologist.';
            }
        }

        // Age considerations
        if ($clientProfile->user && $clientProfile->user->date_of_birth) {
            $age = Carbon::parse($clientProfile->user->date_of_birth)->age;
            if ($age > 65 && in_array($this->category, ['strength', 'muscle_building'])) {
                $warnings[] = 'Client is over 65. Strength training should focus on functional movements and balance.';
            }
        }

        return $warnings;
    }

    /**
     * Get recommended goal adjustments based on medical conditions
     */
    public function getMedicalRecommendations($clientProfile)
    {
        $recommendations = [];

        $medicalConditions = $clientProfile->medical_conditions ?? [];
        $injuries = $clientProfile->injuries ?? [];

        // General recommendations based on conditions
        if (in_array('arthritis', $medicalConditions)) {
            $recommendations[] = 'Low-impact exercises recommended. Avoid high-impact activities.';
        }

        if (in_array('asthma', $medicalConditions)) {
            $recommendations[] = 'Monitor breathing during exercise. Have rescue inhaler available.';
        }

        if (in_array('osteoporosis', $medicalConditions)) {
            $recommendations[] = 'Focus on weight-bearing exercises. Avoid exercises that compress spine.';
        }

        if (!empty($injuries)) {
            $recommendations[] = 'Current injuries noted. Modify exercises to avoid affected areas.';
        }

        return $recommendations;
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    public function calculateStartValue()
    {
        // Get the first tracking entry as start value
        $firstTracking = $this->trackings()->orderBy('tracking_date')->first();
        return $firstTracking ? $firstTracking->value : null;
    }
}
