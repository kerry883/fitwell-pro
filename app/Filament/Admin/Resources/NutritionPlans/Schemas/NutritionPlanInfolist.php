<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Schemas;

use App\Models\NutritionPlan;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NutritionPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_program_id')
                    ->numeric(),
                TextEntry::make('plan_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('daily_calories')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('protein_grams')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('carbs_grams')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('fat_grams')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('meals_per_day')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('start_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (NutritionPlan $record): bool => $record->trashed()),
            ]);
    }
}
