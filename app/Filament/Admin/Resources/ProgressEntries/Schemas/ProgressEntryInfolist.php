<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Schemas;

use App\Models\ProgressEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProgressEntryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('entry_date')
                    ->date(),
                TextEntry::make('entry_type')
                    ->badge(),
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
                    ->visible(fn (ProgressEntry $record): bool => $record->trashed()),
            ]);
    }
}
