<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('subscription_id')
                    ->numeric(),
                TextInput::make('appointment_id')
                    ->numeric(),
                TextInput::make('client_program_id')
                    ->numeric(),
                TextInput::make('invoice_number'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                Select::make('payment_type')
                    ->options([
            'ONE_TIME' => 'O n e  t i m e',
            'SUBSCRIPTION' => 'S u b s c r i p t i o n',
            'SESSION' => 'S e s s i o n',
            'PROGRAM' => 'P r o g r a m',
        ])
                    ->required(),
                Select::make('payment_method')
                    ->options([
            'CARD' => 'C a r d',
            'BANK_TRANSFER' => 'B a n k  t r a n s f e r',
            'CASH' => 'C a s h',
            'MOBILE_MONEY' => 'M o b i l e  m o n e y',
            'OTHER' => 'O t h e r',
        ])
                    ->required(),
                DatePicker::make('payment_date'),
                DatePicker::make('due_date'),
                Select::make('status')
                    ->options([
            'PENDING' => 'P e n d i n g',
            'COMPLETED' => 'C o m p l e t e d',
            'FAILED' => 'F a i l e d',
            'REFUNDED' => 'R e f u n d e d',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('PENDING')
                    ->required(),
                TextInput::make('transaction_id'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
