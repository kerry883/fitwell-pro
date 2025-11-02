<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Pages;

use App\Filament\Admin\Resources\AppointmentReminders\AppointmentReminderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentReminder extends EditRecord
{
    protected static string $resource = AppointmentReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
