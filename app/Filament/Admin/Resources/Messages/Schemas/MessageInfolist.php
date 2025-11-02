<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use App\Models\Message;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sender_id')
                    ->numeric(),
                TextEntry::make('receiver_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('thread_id')
                    ->numeric(),
                TextEntry::make('message_content')
                    ->columnSpanFull(),
                IconEntry::make('is_read')
                    ->boolean(),
                TextEntry::make('read_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('sent_at')
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
                    ->visible(fn (Message $record): bool => $record->trashed()),
            ]);
    }
}
