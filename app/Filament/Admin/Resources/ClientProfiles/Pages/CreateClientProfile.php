<?php

namespace App\Filament\Admin\Resources\ClientProfiles\Pages;

use App\Filament\Admin\Resources\ClientProfiles\ClientProfileResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientProfile extends CreateRecord
{
    protected static string $resource = ClientProfileResource::class;
}
