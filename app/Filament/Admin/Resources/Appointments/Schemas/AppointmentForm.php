<?php

namespace App\Filament\Admin\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trainer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->numeric(),
                TextInput::make('recurring_pattern_id')
                    ->numeric(),
                Select::make('session_type')
                    ->options(['INDIVIDUAL' => 'I n d i v i d u a l', 'GROUP' => 'G r o u p'])
                    ->default('INDIVIDUAL')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DateTimePicker::make('scheduled_start')
                    ->required(),
                DateTimePicker::make('scheduled_end')
                    ->required(),
                TextInput::make('location'),
                TextInput::make('meeting_link'),
                Select::make('status')
                    ->options([
            'SCHEDULED' => 'S c h e d u l e d',
            'CONFIRMED' => 'C o n f i r m e d',
            'COMPLETED' => 'C o m p l e t e d',
            'CANCELLED' => 'C a n c e l l e d',
            'NO_SHOW' => 'N o  s h o w',
            'RESCHEDULED' => 'R e s c h e d u l e d',
        ])
                    ->default('SCHEDULED')
                    ->required(),
                Toggle::make('is_recurring')
                    ->required(),
                Textarea::make('cancellation_reason')
                    ->columnSpanFull(),
            ]);
    }
}
