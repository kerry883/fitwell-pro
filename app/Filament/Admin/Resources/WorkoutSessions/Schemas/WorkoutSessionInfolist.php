<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Schemas;

use App\Models\WorkoutSession;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkoutSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_program_id')
                    ->numeric(),
                TextEntry::make('phase_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('week_number')
                    ->numeric(),
                TextEntry::make('day_number')
                    ->numeric(),
                TextEntry::make('session_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('session_type')
                    ->badge(),
                TextEntry::make('estimated_duration_minutes')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (WorkoutSession $record): bool => $record->trashed()),
            ]);
    }
}
