<?php

namespace App\Filament\Admin\Resources\EmergencyContacts\Pages;

use App\Filament\Admin\Resources\EmergencyContacts\EmergencyContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmergencyContacts extends ListRecords
{
    protected static string $resource = EmergencyContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
