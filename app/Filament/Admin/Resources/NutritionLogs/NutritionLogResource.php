<?php

namespace App\Filament\Admin\Resources\NutritionLogs;

use App\Filament\Admin\Resources\NutritionLogs\Pages\CreateNutritionLog;
use App\Filament\Admin\Resources\NutritionLogs\Pages\EditNutritionLog;
use App\Filament\Admin\Resources\NutritionLogs\Pages\ListNutritionLogs;
use App\Filament\Admin\Resources\NutritionLogs\Pages\ViewNutritionLog;
use App\Filament\Admin\Resources\NutritionLogs\Schemas\NutritionLogForm;
use App\Filament\Admin\Resources\NutritionLogs\Schemas\NutritionLogInfolist;
use App\Filament\Admin\Resources\NutritionLogs\Tables\NutritionLogsTable;
use App\Models\NutritionLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NutritionLogResource extends Resource
{
    protected static ?string $model = NutritionLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nutrition Logs';

    public static function form(Schema $schema): Schema
    {
        return NutritionLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NutritionLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NutritionLogsTable::configure($table);
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
            'index' => ListNutritionLogs::route('/'),
            'create' => CreateNutritionLog::route('/create'),
            'view' => ViewNutritionLog::route('/{record}'),
            'edit' => EditNutritionLog::route('/{record}/edit'),
        ];
    }
}
