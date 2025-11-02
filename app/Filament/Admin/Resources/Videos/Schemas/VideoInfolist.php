<?php

namespace App\Filament\Admin\Resources\Videos\Schemas;

use App\Models\Video;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VideoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('session_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('exercise_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('video_type')
                    ->badge(),
                TextEntry::make('video_url'),
                TextEntry::make('thumbnail_url')
                    ->placeholder('-'),
                TextEntry::make('duration_seconds')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('client_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('recorded_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('review_status')
                    ->badge(),
                TextEntry::make('uploaded_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('reviewed_at')
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
                    ->visible(fn (Video $record): bool => $record->trashed()),
            ]);
    }
}
