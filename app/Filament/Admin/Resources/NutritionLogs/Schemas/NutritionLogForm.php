<?php

namespace App\Filament\Admin\Resources\NutritionLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class NutritionLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('nutrition_plan_id')
                    ->numeric(),
                DatePicker::make('log_date')
                    ->required(),
                Select::make('meal_type')
                    ->options([
            'BREAKFAST' => 'B r e a k f a s t',
            'LUNCH' => 'L u n c h',
            'DINNER' => 'D i n n e r',
            'SNACK' => 'S n a c k',
            'OTHER' => 'O t h e r',
        ])
                    ->required(),
                Textarea::make('meal_description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('calories')
                    ->numeric(),
                TextInput::make('protein')
                    ->numeric(),
                TextInput::make('carbs')
                    ->numeric(),
                TextInput::make('fat')
                    ->numeric(),
                TextInput::make('photo_url')
                    ->url(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('logged_at'),
            ]);
    }
}
