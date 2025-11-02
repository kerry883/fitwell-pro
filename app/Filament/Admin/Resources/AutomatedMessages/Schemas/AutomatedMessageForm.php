<?php

namespace App\Filament\Admin\Resources\AutomatedMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AutomatedMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('template_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                Select::make('trigger_condition')
                    ->options([
            'TIME_BASED' => 'T i m e  b a s e d',
            'EVENT_BASED' => 'E v e n t  b a s e d',
            'CONDITION_BASED' => 'C o n d i t i o n  b a s e d',
        ])
                    ->required(),
                TextInput::make('trigger_rules'),
                DateTimePicker::make('scheduled_for'),
                Select::make('status')
                    ->options([
            'PENDING' => 'P e n d i n g',
            'SENT' => 'S e n t',
            'FAILED' => 'F a i l e d',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('PENDING')
                    ->required(),
                DateTimePicker::make('sent_at'),
            ]);
    }
}
