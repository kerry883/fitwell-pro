<?php

namespace App\Filament\Admin\Resources\MealPlans\Pages;

use App\Filament\Admin\Resources\MealPlans\MealPlanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMealPlan extends ViewRecord
{
    protected static string $resource = MealPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
