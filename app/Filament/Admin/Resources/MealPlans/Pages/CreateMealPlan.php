<?php

namespace App\Filament\Admin\Resources\MealPlans\Pages;

use App\Filament\Admin\Resources\MealPlans\MealPlanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMealPlan extends CreateRecord
{
    protected static string $resource = MealPlanResource::class;
}
