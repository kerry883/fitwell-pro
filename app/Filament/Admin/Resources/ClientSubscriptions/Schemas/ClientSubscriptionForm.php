<?php

namespace App\Filament\Admin\Resources\ClientSubscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClientSubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('package_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                DatePicker::make('next_billing_date'),
                Select::make('billing_frequency')
                    ->options([
            'MONTHLY' => 'M o n t h l y',
            'QUARTERLY' => 'Q u a r t e r l y',
            'YEARLY' => 'Y e a r l y',
            'ONE_TIME' => 'O n e  t i m e',
        ])
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                Select::make('status')
                    ->options([
            'ACTIVE' => 'A c t i v e',
            'PAUSED' => 'P a u s e d',
            'CANCELLED' => 'C a n c e l l e d',
            'EXPIRED' => 'E x p i r e d',
        ])
                    ->default('ACTIVE')
                    ->required(),
                Toggle::make('auto_renew')
                    ->required(),
                DateTimePicker::make('cancelled_at'),
            ]);
    }
}
