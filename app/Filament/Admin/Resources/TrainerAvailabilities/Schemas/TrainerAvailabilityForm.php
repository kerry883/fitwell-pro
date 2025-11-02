<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TrainerAvailabilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trainer_id')
                    ->required()
                    ->numeric(),
                Select::make('day_of_week')
                    ->options([
            'MONDAY' => 'M o n d a y',
            'TUESDAY' => 'T u e s d a y',
            'WEDNESDAY' => 'W e d n e s d a y',
            'THURSDAY' => 'T h u r s d a y',
            'FRIDAY' => 'F r i d a y',
            'SATURDAY' => 'S a t u r d a y',
            'SUNDAY' => 'S u n d a y',
        ])
                    ->required(),
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
                Toggle::make('is_recurring')
                    ->required(),
                DatePicker::make('effective_from'),
                DatePicker::make('effective_until'),
                TextInput::make('slot_duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(60),
                TextInput::make('buffer_time_minutes')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
