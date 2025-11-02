<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Pages;

use App\Filament\Admin\Resources\AppointmentReminders\AppointmentReminderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppointmentReminders extends ListRecords
{
    protected static string $resource = AppointmentReminderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
