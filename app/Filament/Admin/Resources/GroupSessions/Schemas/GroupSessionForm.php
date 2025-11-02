<?php

namespace App\Filament\Admin\Resources\GroupSessions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GroupSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('appointment_id')
                    ->required()
                    ->numeric(),
                TextInput::make('trainer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('session_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('max_participants')
                    ->required()
                    ->numeric(),
                TextInput::make('current_participants')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price_per_person')
                    ->numeric(),
                Select::make('status')
                    ->options([
            'OPEN' => 'O p e n',
            'FULL' => 'F u l l',
            'CANCELLED' => 'C a n c e l l e d',
            'COMPLETED' => 'C o m p l e t e d',
        ])
                    ->default('OPEN')
                    ->required(),
            ]);
    }
}
