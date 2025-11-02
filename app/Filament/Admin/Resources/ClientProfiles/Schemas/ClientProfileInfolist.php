<?php

namespace App\Filament\Admin\Resources\ClientProfiles\Schemas;

use App\Models\ClientProfile;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('date_of_birth')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-'),
                TextEntry::make('city')
                    ->placeholder('-'),
                TextEntry::make('country')
                    ->placeholder('-'),
                TextEntry::make('profile_photo_url')
                    ->placeholder('-'),
                TextEntry::make('timezone'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ClientProfile $record): bool => $record->trashed()),
            ]);
    }
}
