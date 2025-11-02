<?php

namespace App\Filament\Admin\Resources\HealthHistories\Pages;

use App\Filament\Admin\Resources\HealthHistories\HealthHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHealthHistories extends ListRecords
{
    protected static string $resource = HealthHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
