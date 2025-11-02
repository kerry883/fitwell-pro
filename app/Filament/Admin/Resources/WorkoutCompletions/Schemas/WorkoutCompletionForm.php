<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkoutCompletionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('session_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('completed_date')
                    ->required(),
                TextInput::make('actual_duration_minutes')
                    ->numeric(),
                Select::make('status')
                    ->options(['COMPLETED' => 'C o m p l e t e d', 'PARTIAL' => 'P a r t i a l', 'SKIPPED' => 'S k i p p e d'])
                    ->default('COMPLETED')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('rating')
                    ->numeric(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
