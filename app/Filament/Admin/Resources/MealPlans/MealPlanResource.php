<?php

namespace App\Filament\Admin\Resources\MealPlans;

use App\Filament\Admin\Resources\MealPlans\Pages\CreateMealPlan;
use App\Filament\Admin\Resources\MealPlans\Pages\EditMealPlan;
use App\Filament\Admin\Resources\MealPlans\Pages\ListMealPlans;
use App\Filament\Admin\Resources\MealPlans\Pages\ViewMealPlan;
use App\Filament\Admin\Resources\MealPlans\Schemas\MealPlanForm;
use App\Filament\Admin\Resources\MealPlans\Schemas\MealPlanInfolist;
use App\Filament\Admin\Resources\MealPlans\Tables\MealPlansTable;
use App\Models\MealPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MealPlanResource extends Resource
{
    protected static ?string $model = MealPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Meal Plans';

    public static function form(Schema $schema): Schema
    {
        return MealPlanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MealPlanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MealPlansTable::configure($table);
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
            'index' => ListMealPlans::route('/'),
            'create' => CreateMealPlan::route('/create'),
            'view' => ViewMealPlan::route('/{record}'),
            'edit' => EditMealPlan::route('/{record}/edit'),
        ];
    }
}
