<?php

namespace App\Filament\Admin\Resources\MealPlans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MealPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nutrition_plan_id')
                    ->required()
                    ->numeric(),
                Select::make('meal_type')
                    ->options([
            'BREAKFAST' => 'B r e a k f a s t',
            'LUNCH' => 'L u n c h',
            'DINNER' => 'D i n n e r',
            'SNACK' => 'S n a c k',
            'PRE_WORKOUT' => 'P r e  w o r k o u t',
            'POST_WORKOUT' => 'P o s t  w o r k o u t',
        ])
                    ->required(),
                TextInput::make('meal_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('ingredients')
                    ->columnSpanFull(),
                Textarea::make('preparation')
                    ->columnSpanFull(),
                TextInput::make('calories')
                    ->numeric(),
                TextInput::make('protein')
                    ->numeric(),
                TextInput::make('carbs')
                    ->numeric(),
                TextInput::make('fat')
                    ->numeric(),
                TextInput::make('recipe_url')
                    ->url(),
                TextInput::make('allergens'),
            ]);
    }
}
