<?php

namespace App\Filament\Admin\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('payment_id')
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('invoice_number')
                    ->required(),
                DatePicker::make('issue_date')
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                Select::make('status')
                    ->options([
            'DRAFT' => 'D r a f t',
            'SENT' => 'S e n t',
            'PAID' => 'P a i d',
            'OVERDUE' => 'O v e r d u e',
            'CANCELLED' => 'C a n c e l l e d',
        ])
                    ->default('DRAFT')
                    ->required(),
                TextInput::make('line_items'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('invoice_document_url')
                    ->url(),
            ]);
    }
}
