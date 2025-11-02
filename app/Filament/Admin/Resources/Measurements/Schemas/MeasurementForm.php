<?php

namespace App\Filament\Admin\Resources\Measurements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MeasurementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('entry_id')
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('measurement_date')
                    ->required(),
                TextInput::make('weight')
                    ->numeric(),
                TextInput::make('weight_unit')
                    ->required()
                    ->default('kg'),
                TextInput::make('body_fat_percentage')
                    ->numeric(),
                TextInput::make('muscle_mass')
                    ->numeric(),
                TextInput::make('body_measurements'),
                DateTimePicker::make('recorded_at'),
            ]);
    }
}
