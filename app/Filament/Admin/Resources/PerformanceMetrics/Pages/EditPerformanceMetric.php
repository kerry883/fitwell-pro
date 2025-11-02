<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics\Pages;

use App\Filament\Admin\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPerformanceMetric extends EditRecord
{
    protected static string $resource = PerformanceMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
