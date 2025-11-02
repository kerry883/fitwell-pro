<?php

namespace App\Filament\Admin\Resources\ClientGoals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClientGoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('goal_title')
                    ->required(),
                Textarea::make('goal_description')
                    ->columnSpanFull(),
                Select::make('goal_type')
                    ->options([
            'WEIGHT_LOSS' => 'W e i g h t  l o s s',
            'MUSCLE_GAIN' => 'M u s c l e  g a i n',
            'STRENGTH' => 'S t r e n g t h',
            'ENDURANCE' => 'E n d u r a n c e',
            'FLEXIBILITY' => 'F l e x i b i l i t y',
            'HEALTH' => 'H e a l t h',
            'SPORT_SPECIFIC' => 'S p o r t  s p e c i f i c',
            'OTHER' => 'O t h e r',
        ])
                    ->required(),
                TextInput::make('target_value')
                    ->numeric(),
                TextInput::make('target_unit'),
                DatePicker::make('target_date'),
                Select::make('status')
                    ->options([
            'ACTIVE' => 'A c t i v e',
            'COMPLETED' => 'C o m p l e t e d',
            'PAUSED' => 'P a u s e d',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('ACTIVE')
                    ->required(),
                TextInput::make('current_progress')
                    ->numeric(),
            ]);
    }
}
