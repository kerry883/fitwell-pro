<?php

namespace App\Filament\Admin\Resources\RecurringPatterns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RecurringPatternForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('recurrence_type')
                    ->options([
            'DAILY' => 'D a i l y',
            'WEEKLY' => 'W e e k l y',
            'BIWEEKLY' => 'B i w e e k l y',
            'MONTHLY' => 'M o n t h l y',
        ])
                    ->required(),
                TextInput::make('recurrence_rules'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('occurrences_count')
                    ->numeric(),
                TextInput::make('excluded_dates'),
            ]);
    }
}
