<?php

namespace App\Filament\Admin\Resources\Packages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('created_by_trainer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('package_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('package_type')
                    ->options([
            'ONE_TIME' => 'O n e  t i m e',
            'SUBSCRIPTION' => 'S u b s c r i p t i o n',
            'PER_SESSION' => 'P e r  s e s s i o n',
            'PER_PROGRAM' => 'P e r  p r o g r a m',
        ])
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('duration_days')
                    ->numeric(),
                TextInput::make('session_count')
                    ->numeric(),
                TextInput::make('features_included'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
