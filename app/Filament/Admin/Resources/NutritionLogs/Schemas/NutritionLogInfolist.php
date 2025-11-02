<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Schemas;

use App\Models\NutritionLog;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NutritionLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('nutrition_plan_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('log_date')
                    ->date(),
                TextEntry::make('meal_type')
                    ->badge(),
                TextEntry::make('meal_description')
                    ->columnSpanFull(),
                TextEntry::make('calories')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('protein')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('carbs')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('fat')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('photo_url')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('logged_at')
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
                    ->visible(fn (NutritionLog $record): bool => $record->trashed()),
            ]);
    }
}
