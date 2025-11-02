<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics\Pages;

use App\Filament\Admin\Resources\PerformanceMetrics\PerformanceMetricResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerformanceMetric extends CreateRecord
{
    protected static string $resource = PerformanceMetricResource::class;
}
