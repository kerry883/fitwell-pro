<?php

namespace App\Filament\Admin\Resources\SessionParticipants\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SessionParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('group_session_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('joined_at'),
                Select::make('attendance_status')
                    ->options([
            'REGISTERED' => 'R e g i s t e r e d',
            'ATTENDED' => 'A t t e n d e d',
            'ABSENT' => 'A b s e n t',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('REGISTERED')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
