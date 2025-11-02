<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Pages;

use App\Filament\Admin\Resources\AppointmentReminders\AppointmentReminderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointmentReminder extends CreateRecord
{
    protected static string $resource = AppointmentReminderResource::class;
}
