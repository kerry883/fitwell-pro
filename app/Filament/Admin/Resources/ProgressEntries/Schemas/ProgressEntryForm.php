<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgressEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('entry_date')
                    ->required(),
                Select::make('entry_type')
                    ->options([
            'MEASUREMENT' => 'M e a s u r e m e n t',
            'PERFORMANCE' => 'P e r f o r m a n c e',
            'PHOTO' => 'P h o t o',
            'ASSESSMENT' => 'A s s e s s m e n t',
            'GENERAL' => 'G e n e r a l',
        ])
                    ->required(),
                TextInput::make('entry_data'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
