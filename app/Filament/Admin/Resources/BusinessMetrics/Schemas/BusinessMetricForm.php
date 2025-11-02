<?php

namespace App\Filament\Admin\Resources\BusinessMetrics\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BusinessMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trainer_id')
                    ->numeric(),
                DatePicker::make('metric_date')
                    ->required(),
                Select::make('metric_type')
                    ->options([
            'RETENTION' => 'R e t e n t i o n',
            'REVENUE' => 'R e v e n u e',
            'ATTENDANCE' => 'A t t e n d a n c e',
            'SATISFACTION' => 'S a t i s f a c t i o n',
            'REFERRAL' => 'R e f e r r a l',
        ])
                    ->required(),
                TextInput::make('metric_name')
                    ->required(),
                TextInput::make('metric_value')
                    ->required()
                    ->numeric(),
                TextInput::make('metric_details'),
                DateTimePicker::make('calculated_at'),
            ]);
    }
}
