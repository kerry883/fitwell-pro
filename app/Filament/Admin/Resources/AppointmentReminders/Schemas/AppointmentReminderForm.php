<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AppointmentReminderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('appointment_id')
                    ->required()
                    ->numeric(),
                Select::make('reminder_type')
                    ->options(['EMAIL' => 'E m a i l', 'SMS' => 'S m s', 'PUSH' => 'P u s h', 'IN_APP' => 'I n  a p p'])
                    ->required(),
                TextInput::make('minutes_before')
                    ->required()
                    ->numeric(),
                Toggle::make('is_sent')
                    ->required(),
                DateTimePicker::make('sent_at'),
            ]);
    }
}
