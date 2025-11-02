<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkoutSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_program_id')
                    ->required()
                    ->numeric(),
                TextInput::make('phase_id')
                    ->numeric(),
                TextInput::make('week_number')
                    ->required()
                    ->numeric(),
                TextInput::make('day_number')
                    ->required()
                    ->numeric(),
                TextInput::make('session_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('session_type')
                    ->options([
            'STRENGTH' => 'S t r e n g t h',
            'CARDIO' => 'C a r d i o',
            'FLEXIBILITY' => 'F l e x i b i l i t y',
            'HYBRID' => 'H y b r i d',
            'REST' => 'R e s t',
        ])
                    ->default('STRENGTH')
                    ->required(),
                TextInput::make('estimated_duration_minutes')
                    ->numeric(),
                TextInput::make('warm_up'),
                TextInput::make('cool_down'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
