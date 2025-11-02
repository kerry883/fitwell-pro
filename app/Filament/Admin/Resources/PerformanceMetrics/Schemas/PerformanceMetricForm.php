<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PerformanceMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('entry_id')
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('exercise_id')
                    ->numeric(),
                DatePicker::make('recorded_date')
                    ->required(),
                Select::make('metric_type')
                    ->options([
            'STRENGTH' => 'S t r e n g t h',
            'CARDIO' => 'C a r d i o',
            'FLEXIBILITY' => 'F l e x i b i l i t y',
            'ENDURANCE' => 'E n d u r a n c e',
        ])
                    ->required(),
                TextInput::make('metric_name')
                    ->required(),
                TextInput::make('metric_value')
                    ->required()
                    ->numeric(),
                TextInput::make('metric_unit'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
