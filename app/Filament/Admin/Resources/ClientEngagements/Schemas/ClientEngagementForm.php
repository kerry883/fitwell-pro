<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientEngagementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('tracking_date')
                    ->required(),
                TextInput::make('workouts_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('videos_uploaded')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('messages_sent')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('logins_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('completion_rate')
                    ->numeric(),
                DateTimePicker::make('last_activity'),
            ]);
    }
}
