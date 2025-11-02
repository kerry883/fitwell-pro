<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Pages;

use App\Filament\Admin\Resources\NutritionLogs\NutritionLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNutritionLogs extends ListRecords
{
    protected static string $resource = NutritionLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
