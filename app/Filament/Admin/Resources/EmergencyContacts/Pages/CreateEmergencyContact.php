<?php

namespace App\Filament\Admin\Resources\EmergencyContacts\Pages;

use App\Filament\Admin\Resources\EmergencyContacts\EmergencyContactResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmergencyContact extends CreateRecord
{
    protected static string $resource = EmergencyContactResource::class;
}
