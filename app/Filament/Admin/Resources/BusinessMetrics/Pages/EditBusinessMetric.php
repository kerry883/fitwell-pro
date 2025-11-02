<?php

namespace App\Filament\Admin\Resources\BusinessMetrics\Pages;

use App\Filament\Admin\Resources\BusinessMetrics\BusinessMetricResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBusinessMetric extends EditRecord
{
    protected static string $resource = BusinessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
