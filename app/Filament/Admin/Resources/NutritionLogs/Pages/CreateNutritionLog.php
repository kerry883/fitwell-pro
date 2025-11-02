<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Pages;

use App\Filament\Admin\Resources\NutritionLogs\NutritionLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNutritionLog extends CreateRecord
{
    protected static string $resource = NutritionLogResource::class;
}
