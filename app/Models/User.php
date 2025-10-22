<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_type',
        'gender',
        'age',
        'height',
        'weight',
        'fitness_level',
        'activity_level',
        'fitness_goals',
        'profile_picture',
        'preferences',
        'provider_id',
        'provider_name',
        'provider_token',
        'needs_profile_completion',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'fitness_goals' => 'array',
            'needs_profile_completion' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    public function nutritionEntries()
    {
        return $this->hasMany(NutritionEntry::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }

    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function trainerProfile()
    {
        return $this->hasOne(TrainerProfile::class);
    }

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    /**
     * Helper methods
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getBmiAttribute()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 2);
        }
        return null;
    }

    public function getBmrAttribute()
    {
        if ($this->age && $this->height && $this->weight && $this->gender) {
            $heightInCm = $this->height;
            $weightInKg = $this->weight;
            $age = $this->age;

            if ($this->gender === 'male') {
                // Mifflin-St Jeor Equation for men: BMR = 10 * weight + 6.25 * height - 5 * age + 5
                return round(10 * $weightInKg + 6.25 * $heightInCm - 5 * $age + 5, 2);
            } elseif ($this->gender === 'female') {
                // Mifflin-St Jeor Equation for women: BMR = 10 * weight + 6.25 * height - 5 * age - 161
                return round(10 * $weightInKg + 6.25 * $heightInCm - 5 * $age - 161, 2);
            }
        }
        return null;
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }
    
    /**
     * Verify admin has proper privileges and active status
     */
    public function hasAdminPrivileges()
    {
        if (!$this->isAdmin()) {
            return false;
        }
        
        // Check if admin profile exists and is active
        if (!$this->adminProfile || $this->adminProfile->status !== 'active') {
            return false;
        }
        
        return true;
    }

    public function isTrainer()
    {
        return $this->user_type === 'trainer';
    }

    public function isClient()
    {
        return $this->user_type === 'client';
    }

    public function hasSocialProvider()
    {
        return !empty($this->provider_name);
    }
}
