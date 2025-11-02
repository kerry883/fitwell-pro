<?php

namespace App\Filament\Admin\Resources\MealPlans\Schemas;

use App\Models\MealPlan;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MealPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nutrition_plan_id')
                    ->numeric(),
                TextEntry::make('meal_type')
                    ->badge(),
                TextEntry::make('meal_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('ingredients')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('preparation')
                    ->placeholder('-')
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
                TextEntry::make('recipe_url')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (MealPlan $record): bool => $record->trashed()),
            ]);
    }
}
