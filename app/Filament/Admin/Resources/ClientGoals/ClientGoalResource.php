<?php

namespace App\Filament\Admin\Resources\ClientGoals;

use App\Filament\Admin\Resources\ClientGoals\Pages\CreateClientGoal;
use App\Filament\Admin\Resources\ClientGoals\Pages\EditClientGoal;
use App\Filament\Admin\Resources\ClientGoals\Pages\ListClientGoals;
use App\Filament\Admin\Resources\ClientGoals\Pages\ViewClientGoal;
use App\Filament\Admin\Resources\ClientGoals\Schemas\ClientGoalForm;
use App\Filament\Admin\Resources\ClientGoals\Schemas\ClientGoalInfolist;
use App\Filament\Admin\Resources\ClientGoals\Tables\ClientGoalsTable;
use App\Models\ClientGoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientGoalResource extends Resource
{
    protected static ?string $model = ClientGoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Goals';

    public static function form(Schema $schema): Schema
    {
        return ClientGoalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientGoalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientGoalsTable::configure($table);
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
            'index' => ListClientGoals::route('/'),
            'create' => CreateClientGoal::route('/create'),
            'view' => ViewClientGoal::route('/{record}'),
            'edit' => EditClientGoal::route('/{record}/edit'),
        ];
    }
}
