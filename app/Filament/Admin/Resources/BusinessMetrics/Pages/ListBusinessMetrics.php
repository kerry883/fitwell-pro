<?php

namespace App\Filament\Admin\Resources\BusinessMetrics\Pages;

use App\Filament\Admin\Resources\BusinessMetrics\BusinessMetricResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBusinessMetrics extends ListRecords
{
    protected static string $resource = BusinessMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
