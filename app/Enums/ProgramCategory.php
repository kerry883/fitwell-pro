<?php

namespace App\Enums;

enum ProgramCategory: string
{
    case FITNESS = 'fitness';
    case NUTRITION = 'nutrition';
    
    public function label(): string
    {
        return match($this) {
            self::FITNESS => 'Fitness Program',
            self::NUTRITION => 'Nutrition Program',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
            self::FITNESS => 'bi-lightning-charge',
            self::NUTRITION => 'bi-egg-fried',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::FITNESS => 'primary',
            self::NUTRITION => 'success',
        };
    }
}
