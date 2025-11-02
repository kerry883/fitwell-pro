<?php

namespace App\Filament\Admin\Resources\ProgressPhotos\Schemas;

use App\Models\ProgressPhoto;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProgressPhotoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('entry_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('photo_date')
                    ->date(),
                TextEntry::make('photo_type')
                    ->badge(),
                TextEntry::make('photo_url'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('uploaded_at')
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
                    ->visible(fn (ProgressPhoto $record): bool => $record->trashed()),
            ]);
    }
}
