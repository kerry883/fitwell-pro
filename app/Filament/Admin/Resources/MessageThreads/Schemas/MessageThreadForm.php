<?php

namespace App\Filament\Admin\Resources\MessageThreads\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MessageThreadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('thread_subject'),
                Select::make('thread_type')
                    ->options([
            'ONE_ON_ONE' => 'O n e  o n  o n e',
            'GROUP' => 'G r o u p',
            'ANNOUNCEMENT' => 'A n n o u n c e m e n t',
        ])
                    ->default('ONE_ON_ONE')
                    ->required(),
                DateTimePicker::make('last_message_at'),
            ]);
    }
}
