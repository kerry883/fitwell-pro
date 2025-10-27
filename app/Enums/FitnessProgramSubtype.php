<?php

namespace App\Enums;

enum FitnessProgramSubtype: string
{
    case STRENGTH_TRAINING = 'strength_training';
    case CARDIO_HIIT = 'cardio_hiit';
    case POWERLIFTING = 'powerlifting';
    case WEIGHT_LOSS = 'weight_loss';
    case BODYBUILDING = 'bodybuilding';
    case FUNCTIONAL = 'functional';
    case ATHLETIC = 'athletic';
    case REHABILITATION = 'rehabilitation';
    
    public function label(): string
    {
        return match($this) {
            self::STRENGTH_TRAINING => 'Strength Training',
            self::CARDIO_HIIT => 'Cardio/HIIT',
            self::POWERLIFTING => 'Powerlifting',
            self::WEIGHT_LOSS => 'Weight Loss',
            self::BODYBUILDING => 'Bodybuilding',
            self::FUNCTIONAL => 'Functional Training',
            self::ATHLETIC => 'Athletic Performance',
            self::REHABILITATION => 'Rehabilitation',
        };
    }
}
