<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Pages;

use App\Filament\Admin\Resources\ClientEngagements\ClientEngagementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientEngagements extends ListRecords
{
    protected static string $resource = ClientEngagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
