<?php

namespace App\Filament\Admin\Resources\Measurements\Pages;

use App\Filament\Admin\Resources\Measurements\MeasurementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMeasurement extends CreateRecord
{
    protected static string $resource = MeasurementResource::class;
}
