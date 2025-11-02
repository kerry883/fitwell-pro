<?php

namespace App\Filament\Admin\Resources\ClientPrograms\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('template_id')
                    ->required()
                    ->numeric(),
                TextInput::make('assigned_by_trainer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('program_name')
                    ->required(),
                Select::make('assignment_type')
                    ->options(['STATIC' => 'S t a t i c', 'DYNAMIC_PROGRESSIVE' => 'D y n a m i c  p r o g r e s s i v e'])
                    ->default('STATIC')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                Select::make('status')
                    ->options([
            'ACTIVE' => 'A c t i v e',
            'COMPLETED' => 'C o m p l e t e d',
            'PAUSED' => 'P a u s e d',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('ACTIVE')
                    ->required(),
                TextInput::make('current_week')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('current_phase')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('auto_advance')
                    ->required(),
                TextInput::make('customizations'),
                DateTimePicker::make('assigned_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
