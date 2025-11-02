<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Pages;

use App\Filament\Admin\Resources\NutritionPlans\NutritionPlanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNutritionPlan extends ViewRecord
{
    protected static string $resource = NutritionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
