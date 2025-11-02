<?php

namespace App\Filament\Admin\Resources\BusinessMetrics\Pages;

use App\Filament\Admin\Resources\BusinessMetrics\BusinessMetricResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBusinessMetric extends ViewRecord
{
    protected static string $resource = BusinessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
