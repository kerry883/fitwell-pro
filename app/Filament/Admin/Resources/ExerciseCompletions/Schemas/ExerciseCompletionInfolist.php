<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions\Schemas;

use App\Models\ExerciseCompletion;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExerciseCompletionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('completion_id')
                    ->numeric(),
                TextEntry::make('session_exercise_id')
                    ->numeric(),
                TextEntry::make('sets_completed')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('reps_completed')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight_used')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('duration_seconds')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('distance_completed')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ExerciseCompletion $record): bool => $record->trashed()),
            ]);
    }
}
