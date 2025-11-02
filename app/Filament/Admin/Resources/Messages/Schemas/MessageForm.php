<?php

namespace App\Filament\Admin\Resources\Messages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sender_id')
                    ->required()
                    ->numeric(),
                TextInput::make('receiver_id')
                    ->numeric(),
                TextInput::make('thread_id')
                    ->required()
                    ->numeric(),
                Textarea::make('message_content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('attachments'),
                Toggle::make('is_read')
                    ->required(),
                DateTimePicker::make('read_at'),
                DateTimePicker::make('sent_at'),
            ]);
    }
}
