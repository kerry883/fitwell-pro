<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Schemas;

use App\Models\ClientEngagement;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientEngagementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('tracking_date')
                    ->date(),
                TextEntry::make('workouts_completed')
                    ->numeric(),
                TextEntry::make('videos_uploaded')
                    ->numeric(),
                TextEntry::make('messages_sent')
                    ->numeric(),
                TextEntry::make('logins_count')
                    ->numeric(),
                TextEntry::make('completion_rate')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('last_activity')
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
                    ->visible(fn (ClientEngagement $record): bool => $record->trashed()),
            ]);
    }
}
