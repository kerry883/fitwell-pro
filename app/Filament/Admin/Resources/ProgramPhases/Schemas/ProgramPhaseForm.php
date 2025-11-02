<?php

namespace App\Filament\Admin\Resources\ProgramPhases\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgramPhaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('template_id')
                    ->required()
                    ->numeric(),
                TextInput::make('phase_number')
                    ->required()
                    ->numeric(),
                TextInput::make('phase_name')
                    ->required(),
                Textarea::make('phase_description')
                    ->columnSpanFull(),
                TextInput::make('duration_weeks')
                    ->required()
                    ->numeric(),
                TextInput::make('phase_goals'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
