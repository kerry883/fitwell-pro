<?php

namespace App\Filament\Admin\Resources\Notifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('related_entity_id')
                    ->numeric(),
                Select::make('entity_type')
                    ->options([
            'VIDEO' => 'V i d e o',
            'MESSAGE' => 'M e s s a g e',
            'APPOINTMENT' => 'A p p o i n t m e n t',
            'WORKOUT' => 'W o r k o u t',
            'PAYMENT' => 'P a y m e n t',
            'GOAL' => 'G o a l',
            'ASSESSMENT' => 'A s s e s s m e n t',
        ]),
                TextInput::make('notification_title')
                    ->required(),
                Textarea::make('notification_content')
                    ->required()
                    ->columnSpanFull(),
                Select::make('notification_type')
                    ->options([
            'INFO' => 'I n f o',
            'WARNING' => 'W a r n i n g',
            'SUCCESS' => 'S u c c e s s',
            'REMINDER' => 'R e m i n d e r',
            'ALERT' => 'A l e r t',
        ])
                    ->default('INFO')
                    ->required(),
                Toggle::make('is_read')
                    ->required(),
                DateTimePicker::make('read_at'),
            ]);
    }
}
