<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics\Schemas;

use App\Models\PerformanceMetric;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PerformanceMetricInfolist
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
                TextEntry::make('exercise_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('recorded_date')
                    ->date(),
                TextEntry::make('metric_type')
                    ->badge(),
                TextEntry::make('metric_name'),
                TextEntry::make('metric_value')
                    ->numeric(),
                TextEntry::make('metric_unit')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (PerformanceMetric $record): bool => $record->trashed()),
            ]);
    }
}
