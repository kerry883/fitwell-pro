<?php

namespace App\Filament\Admin\Resources\ClientProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date_of_birth'),
                Select::make('gender')
                    ->options([
            'MALE' => 'M a l e',
            'FEMALE' => 'F e m a l e',
            'OTHER' => 'O t h e r',
            'PREFER_NOT_TO_SAY' => 'P r e f e r  n o t  t o  s a y',
        ]),
                TextInput::make('address'),
                TextInput::make('city'),
                TextInput::make('country'),
                TextInput::make('profile_photo_url')
                    ->url(),
                TextInput::make('timezone')
                    ->required()
                    ->default('UTC'),
                TextInput::make('preferences'),
            ]);
    }
}
