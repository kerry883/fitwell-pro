<?php

namespace App\Filament\Admin\Resources\Measurements\Schemas;

use App\Models\Measurement;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MeasurementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('entry_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('measurement_date')
                    ->date(),
                TextEntry::make('weight')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight_unit'),
                TextEntry::make('body_fat_percentage')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('muscle_mass')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('recorded_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Measurement $record): bool => $record->trashed()),
            ]);
    }
}
