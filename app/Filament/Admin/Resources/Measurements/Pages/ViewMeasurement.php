<?php

namespace App\Filament\Admin\Resources\Measurements\Pages;

use App\Filament\Admin\Resources\Measurements\MeasurementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMeasurement extends ViewRecord
{
    protected static string $resource = MeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
