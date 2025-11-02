<?php

namespace App\Filament\Admin\Resources\MessageThreads\Schemas;

use App\Models\MessageThread;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MessageThreadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('thread_subject')
                    ->placeholder('-'),
                TextEntry::make('thread_type')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('last_message_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MessageThread $record): bool => $record->trashed()),
            ]);
    }
}
