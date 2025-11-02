<?php

namespace App\Filament\Admin\Resources\SessionExercises\Schemas;

use App\Models\SessionExercise;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SessionExerciseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('session_id')
                    ->numeric(),
                TextEntry::make('exercise_id')
                    ->numeric(),
                TextEntry::make('exercise_order')
                    ->numeric(),
                TextEntry::make('sets')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('reps')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight_unit')
                    ->placeholder('-'),
                TextEntry::make('duration_seconds')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('distance')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('distance_unit')
                    ->placeholder('-'),
                TextEntry::make('rest_seconds')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_superset')
                    ->boolean(),
                TextEntry::make('superset_group')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (SessionExercise $record): bool => $record->trashed()),
            ]);
    }
}
