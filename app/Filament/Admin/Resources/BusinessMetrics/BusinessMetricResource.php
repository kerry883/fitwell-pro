<?php

namespace App\Filament\Admin\Resources\BusinessMetrics;

use App\Filament\Admin\Resources\BusinessMetrics\Pages\CreateBusinessMetric;
use App\Filament\Admin\Resources\BusinessMetrics\Pages\EditBusinessMetric;
use App\Filament\Admin\Resources\BusinessMetrics\Pages\ListBusinessMetrics;
use App\Filament\Admin\Resources\BusinessMetrics\Pages\ViewBusinessMetric;
use App\Filament\Admin\Resources\BusinessMetrics\Schemas\BusinessMetricForm;
use App\Filament\Admin\Resources\BusinessMetrics\Schemas\BusinessMetricInfolist;
use App\Filament\Admin\Resources\BusinessMetrics\Tables\BusinessMetricsTable;
use App\Models\BusinessMetric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BusinessMetricResource extends Resource
{
    protected static ?string $model = BusinessMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'BusinessMetrics';

    public static function form(Schema $schema): Schema
    {
        return BusinessMetricForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BusinessMetricInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BusinessMetricsTable::configure($table);
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
            'index' => ListBusinessMetrics::route('/'),
            'create' => CreateBusinessMetric::route('/create'),
            'view' => ViewBusinessMetric::route('/{record}'),
            'edit' => EditBusinessMetric::route('/{record}/edit'),
        ];
    }
}
