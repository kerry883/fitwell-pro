<?php

namespace App\Filament\Admin\Resources\ExerciseCategories\Schemas;

use App\Models\ExerciseCategory;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExerciseCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('parent_category_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ExerciseCategory $record): bool => $record->trashed()),
            ]);
    }
}
