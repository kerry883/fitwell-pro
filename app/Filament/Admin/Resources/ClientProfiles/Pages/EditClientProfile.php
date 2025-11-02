<?php

namespace App\Filament\Admin\Resources\ClientProfiles\Pages;

use App\Filament\Admin\Resources\ClientProfiles\ClientProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClientProfile extends EditRecord
{
    protected static string $resource = ClientProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
