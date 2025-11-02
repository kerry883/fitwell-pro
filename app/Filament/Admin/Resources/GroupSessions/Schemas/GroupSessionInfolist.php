<?php

namespace App\Filament\Admin\Resources\GroupSessions\Schemas;

use App\Models\GroupSession;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GroupSessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('appointment_id')
                    ->numeric(),
                TextEntry::make('trainer_id')
                    ->numeric(),
                TextEntry::make('session_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('max_participants')
                    ->numeric(),
                TextEntry::make('current_participants')
                    ->numeric(),
                TextEntry::make('price_per_person')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (GroupSession $record): bool => $record->trashed()),
            ]);
    }
}
