<?php

namespace App\Filament\Admin\Resources\Exercises\Schemas;

use App\Models\Exercise;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExerciseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_by_trainer_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('category_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('exercise_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('instructions')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('difficulty_level')
                    ->badge(),
                TextEntry::make('video_demo_url')
                    ->placeholder('-'),
                ImageEntry::make('image_url')
                    ->placeholder('-'),
                IconEntry::make('is_custom')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Exercise $record): bool => $record->trashed()),
            ]);
    }
}
