<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Pages;

use App\Filament\Admin\Resources\AppointmentReminders\AppointmentReminderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointmentReminder extends ViewRecord
{
    protected static string $resource = AppointmentReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
