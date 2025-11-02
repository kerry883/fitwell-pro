<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Pages;

use App\Filament\Admin\Resources\NutritionLogs\NutritionLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNutritionLog extends EditRecord
{
    protected static string $resource = NutritionLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
