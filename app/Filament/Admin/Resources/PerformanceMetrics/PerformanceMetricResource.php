<?php

namespace App\Filament\Admin\Resources\PerformanceMetrics;

use App\Filament\Admin\Resources\PerformanceMetrics\Pages\CreatePerformanceMetric;
use App\Filament\Admin\Resources\PerformanceMetrics\Pages\EditPerformanceMetric;
use App\Filament\Admin\Resources\PerformanceMetrics\Pages\ListPerformanceMetrics;
use App\Filament\Admin\Resources\PerformanceMetrics\Pages\ViewPerformanceMetric;
use App\Filament\Admin\Resources\PerformanceMetrics\Schemas\PerformanceMetricForm;
use App\Filament\Admin\Resources\PerformanceMetrics\Schemas\PerformanceMetricInfolist;
use App\Filament\Admin\Resources\PerformanceMetrics\Tables\PerformanceMetricsTable;
use App\Models\PerformanceMetric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerformanceMetricResource extends Resource
{
    protected static ?string $model = PerformanceMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PerformanceMetric';

    public static function form(Schema $schema): Schema
    {
        return PerformanceMetricForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PerformanceMetricInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformanceMetricsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPerformanceMetrics::route('/'),
            'create' => CreatePerformanceMetric::route('/create'),
            'view' => ViewPerformanceMetric::route('/{record}'),
            'edit' => EditPerformanceMetric::route('/{record}/edit'),
        ];
    }
}
