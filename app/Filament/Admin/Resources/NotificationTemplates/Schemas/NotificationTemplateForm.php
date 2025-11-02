<?php

namespace App\Filament\Admin\Resources\NotificationTemplates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NotificationTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('template_name')
                    ->required(),
                Select::make('trigger_event')
                    ->options([
            'WELCOME' => 'W e l c o m e',
            'WORKOUT_REMINDER' => 'W o r k o u t  r e m i n d e r',
            'MISSED_SESSION' => 'M i s s e d  s e s s i o n',
            'MILESTONE' => 'M i l e s t o n e',
            'PAYMENT_DUE' => 'P a y m e n t  d u e',
            'PROGRAM_START' => 'P r o g r a m  s t a r t',
            'PROGRAM_END' => 'P r o g r a m  e n d',
        ])
                    ->required(),
                TextInput::make('subject')
                    ->required(),
                Textarea::make('email_template')
                    ->columnSpanFull(),
                Textarea::make('sms_template')
                    ->columnSpanFull(),
                Textarea::make('push_template')
                    ->columnSpanFull(),
                TextInput::make('template_variables'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
