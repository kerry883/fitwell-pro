<?php

namespace App\Filament\Admin\Resources\ClientProfiles\Pages;

use App\Filament\Admin\Resources\ClientProfiles\ClientProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientProfiles extends ListRecords
{
    protected static string $resource = ClientProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
