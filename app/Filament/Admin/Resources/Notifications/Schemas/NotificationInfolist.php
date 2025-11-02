<?php

namespace App\Filament\Admin\Resources\Notifications\Schemas;

use App\Models\Notification;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NotificationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('related_entity_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('entity_type')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('notification_title'),
                TextEntry::make('notification_content')
                    ->columnSpanFull(),
                TextEntry::make('notification_type')
                    ->badge(),
                IconEntry::make('is_read')
                    ->boolean(),
                TextEntry::make('read_at')
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
                    ->visible(fn (Notification $record): bool => $record->trashed()),
            ]);
    }
}
