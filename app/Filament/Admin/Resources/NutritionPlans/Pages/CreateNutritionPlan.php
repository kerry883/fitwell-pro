<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Pages;

use App\Filament\Admin\Resources\NutritionPlans\NutritionPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNutritionPlan extends CreateRecord
{
    protected static string $resource = NutritionPlanResource::class;
}
