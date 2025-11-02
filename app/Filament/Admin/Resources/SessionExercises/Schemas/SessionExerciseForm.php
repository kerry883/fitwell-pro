<?php

namespace App\Filament\Admin\Resources\SessionExercises\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SessionExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('session_id')
                    ->required()
                    ->numeric(),
                TextInput::make('exercise_id')
                    ->required()
                    ->numeric(),
                TextInput::make('exercise_order')
                    ->required()
                    ->numeric(),
                TextInput::make('sets')
                    ->numeric(),
                TextInput::make('reps')
                    ->numeric(),
                TextInput::make('weight')
                    ->numeric(),
                TextInput::make('weight_unit')
                    ->default('kg'),
                TextInput::make('duration_seconds')
                    ->numeric(),
                TextInput::make('distance')
                    ->numeric(),
                TextInput::make('distance_unit')
                    ->default('km'),
                TextInput::make('rest_seconds')
                    ->numeric(),
                TextInput::make('tempo'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Toggle::make('is_superset')
                    ->required(),
                TextInput::make('superset_group')
                    ->numeric(),
            ]);
    }
}
