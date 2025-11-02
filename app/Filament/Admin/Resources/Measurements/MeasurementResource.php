<?php

namespace App\Filament\Admin\Resources\Measurements;

use App\Filament\Admin\Resources\Measurements\Pages\CreateMeasurement;
use App\Filament\Admin\Resources\Measurements\Pages\EditMeasurement;
use App\Filament\Admin\Resources\Measurements\Pages\ListMeasurements;
use App\Filament\Admin\Resources\Measurements\Pages\ViewMeasurement;
use App\Filament\Admin\Resources\Measurements\Schemas\MeasurementForm;
use App\Filament\Admin\Resources\Measurements\Schemas\MeasurementInfolist;
use App\Filament\Admin\Resources\Measurements\Tables\MeasurementsTable;
use App\Models\Measurement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeasurementResource extends Resource
{
    protected static ?string $model = Measurement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Measurements';

    public static function form(Schema $schema): Schema
    {
        return MeasurementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeasurementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementsTable::configure($table);
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
            'index' => ListMeasurements::route('/'),
            'create' => CreateMeasurement::route('/create'),
            'view' => ViewMeasurement::route('/{record}'),
            'edit' => EditMeasurement::route('/{record}/edit'),
        ];
    }
}
