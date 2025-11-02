<?php

namespace App\Filament\Admin\Resources\ProgressPhotos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgressPhotoForm
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
                DatePicker::make('photo_date')
                    ->required(),
                Select::make('photo_type')
                    ->options([
            'FRONT' => 'F r o n t',
            'SIDE' => 'S i d e',
            'BACK' => 'B a c k',
            'PROGRESS' => 'P r o g r e s s',
            'OTHER' => 'O t h e r',
        ])
                    ->required(),
                TextInput::make('photo_url')
                    ->url()
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('uploaded_at'),
            ]);
    }
}
