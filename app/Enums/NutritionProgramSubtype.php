<?php

namespace App\Enums;

enum NutritionProgramSubtype: string
{
    case WEIGHT_LOSS = 'weight_loss';
    case MUSCLE_GAIN = 'muscle_gain';
    case MAINTENANCE = 'maintenance';
    case PERFORMANCE = 'performance';
    case KETO = 'keto';
    case VEGAN = 'vegan';
    case PALEO = 'paleo';
    case MEDITERRANEAN = 'mediterranean';
    case INTERMITTENT_FASTING = 'intermittent_fasting';
    case DIABETIC_FRIENDLY = 'diabetic_friendly';
    
    public function label(): string
    {
        return match($this) {
            self::WEIGHT_LOSS => 'Weight Loss Nutrition',
            self::MUSCLE_GAIN => 'Muscle Gain Nutrition',
            self::MAINTENANCE => 'Maintenance Nutrition',
            self::PERFORMANCE => 'Athletic Performance',
            self::KETO => 'Ketogenic Diet',
            self::VEGAN => 'Vegan Diet',
            self::PALEO => 'Paleo Diet',
            self::MEDITERRANEAN => 'Mediterranean Diet',
            self::INTERMITTENT_FASTING => 'Intermittent Fasting',
            self::DIABETIC_FRIENDLY => 'Diabetic-Friendly',
        };
    }
}
