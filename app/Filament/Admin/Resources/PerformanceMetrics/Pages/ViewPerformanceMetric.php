<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics\Pages;

use App\Filament\Admin\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPerformanceMetric extends ViewRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
