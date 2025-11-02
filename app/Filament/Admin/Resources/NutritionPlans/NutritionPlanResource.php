<?php

namespace App\Filament\Admin\Resources\NutritionPlans;

use App\Filament\Admin\Resources\NutritionPlans\Pages\CreateNutritionPlan;
use App\Filament\Admin\Resources\NutritionPlans\Pages\EditNutritionPlan;
use App\Filament\Admin\Resources\NutritionPlans\Pages\ListNutritionPlans;
use App\Filament\Admin\Resources\NutritionPlans\Pages\ViewNutritionPlan;
use App\Filament\Admin\Resources\NutritionPlans\Schemas\NutritionPlanForm;
use App\Filament\Admin\Resources\NutritionPlans\Schemas\NutritionPlanInfolist;
use App\Filament\Admin\Resources\NutritionPlans\Tables\NutritionPlansTable;
use App\Models\NutritionPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NutritionPlanResource extends Resource
{
    protected static ?string $model = NutritionPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nutrition Plan';

    public static function form(Schema $schema): Schema
    {
        return NutritionPlanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NutritionPlanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NutritionPlansTable::configure($table);
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
            'index' => ListNutritionPlans::route('/'),
            'create' => CreateNutritionPlan::route('/create'),
            'view' => ViewNutritionPlan::route('/{record}'),
            'edit' => EditNutritionPlan::route('/{record}/edit'),
        ];
    }
}
