<?php

namespace App\Filament\Admin\Resources\HealthHistories;

use App\Filament\Admin\Resources\HealthHistories\Pages\CreateHealthHistory;
use App\Filament\Admin\Resources\HealthHistories\Pages\EditHealthHistory;
use App\Filament\Admin\Resources\HealthHistories\Pages\ListHealthHistories;
use App\Filament\Admin\Resources\HealthHistories\Schemas\HealthHistoryForm;
use App\Filament\Admin\Resources\HealthHistories\Tables\HealthHistoriesTable;
use App\Models\HealthHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HealthHistoryResource extends Resource
{
    protected static ?string $model = HealthHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'make:filament-resource ExerciseCategory --generate && php artisan make:filament-resource Exercise --generate &&';

    public static function form(Schema $schema): Schema
    {
        return HealthHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HealthHistoriesTable::configure($table);
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
            'index' => ListHealthHistories::route('/'),
            'create' => CreateHealthHistory::route('/create'),
            'edit' => EditHealthHistory::route('/{record}/edit'),
        ];
    }
}
