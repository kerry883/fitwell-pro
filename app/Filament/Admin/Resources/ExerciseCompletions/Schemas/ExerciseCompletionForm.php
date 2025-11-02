<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExerciseCompletionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('completion_id')
                    ->required()
                    ->numeric(),
                TextInput::make('session_exercise_id')
                    ->required()
                    ->numeric(),
                TextInput::make('sets_completed')
                    ->numeric(),
                TextInput::make('reps_completed')
                    ->numeric(),
                TextInput::make('weight_used')
                    ->numeric(),
                TextInput::make('duration_seconds')
                    ->numeric(),
                TextInput::make('distance_completed')
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
