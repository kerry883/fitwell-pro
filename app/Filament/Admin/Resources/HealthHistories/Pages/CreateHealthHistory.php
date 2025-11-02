<?php

namespace App\Filament\Admin\Resources\HealthHistories\Pages;

use App\Filament\Admin\Resources\HealthHistories\HealthHistoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHealthHistory extends CreateRecord
{
    protected static string $resource = HealthHistoryResource::class;
}
