<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Pages;

use App\Filament\Admin\Resources\NutritionPlans\NutritionPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNutritionPlans extends ListRecords
{
    protected static string $resource = NutritionPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
