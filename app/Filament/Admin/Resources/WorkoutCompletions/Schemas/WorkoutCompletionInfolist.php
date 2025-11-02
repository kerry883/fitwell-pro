<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions\Schemas;

use App\Models\WorkoutCompletion;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkoutCompletionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('session_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('completed_date')
                    ->date(),
                TextEntry::make('actual_duration_minutes')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('rating')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (WorkoutCompletion $record): bool => $record->trashed()),
            ]);
    }
}
