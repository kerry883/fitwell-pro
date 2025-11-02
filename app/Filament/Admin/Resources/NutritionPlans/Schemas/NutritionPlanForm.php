<?php

namespace App\Filament\Admin\Resources\NutritionPlans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NutritionPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_program_id')
                    ->required()
                    ->numeric(),
                TextInput::make('plan_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('daily_calories')
                    ->numeric(),
                TextInput::make('protein_grams')
                    ->numeric(),
                TextInput::make('carbs_grams')
                    ->numeric(),
                TextInput::make('fat_grams')
                    ->numeric(),
                TextInput::make('meals_per_day')
                    ->numeric()
                    ->default(3),
                TextInput::make('dietary_restrictions'),
                TextInput::make('meal_timing'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Select::make('status')
                    ->options(['ACTIVE' => 'A c t i v e', 'INACTIVE' => 'I n a c t i v e'])
                    ->default('ACTIVE')
                    ->required(),
            ]);
    }
}
