<?php

namespace App\Filament\Admin\Resources\BusinessMetrics\Schemas;

use App\Models\BusinessMetric;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BusinessMetricInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainer_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('metric_date')
                    ->date(),
                TextEntry::make('metric_type')
                    ->badge(),
                TextEntry::make('metric_name'),
                TextEntry::make('metric_value')
                    ->numeric(),
                TextEntry::make('calculated_at')
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
                    ->visible(fn (BusinessMetric $record): bool => $record->trashed()),
            ]);
    }
}
