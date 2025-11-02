<?php

namespace App\Filament\Admin\Resources\RecurringPatterns\Schemas;

use App\Models\RecurringPattern;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RecurringPatternInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('recurrence_type')
                    ->badge(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('occurrences_count')
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
                    ->visible(fn (RecurringPattern $record): bool => $record->trashed()),
            ]);
    }
}
