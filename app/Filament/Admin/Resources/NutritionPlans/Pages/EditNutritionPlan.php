<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Pages;

use App\Filament\Admin\Resources\NutritionPlans\NutritionPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNutritionPlan extends EditRecord
{
    protected static string $resource = NutritionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
