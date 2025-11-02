<?php

namespace App\Filament\Admin\Resources\SessionParticipants\Schemas;

use App\Models\SessionParticipant;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SessionParticipantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('group_session_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('joined_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('attendance_status')
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
                    ->visible(fn (SessionParticipant $record): bool => $record->trashed()),
            ]);
    }
}
