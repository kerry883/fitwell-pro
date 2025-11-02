<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Pages;

use App\Filament\Admin\Resources\NutritionLogs\NutritionLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNutritionLog extends ViewRecord
{
    protected static string $resource = NutritionLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
