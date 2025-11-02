<?php

namespace App\Filament\Admin\Resources\ExerciseCategories;

use App\Filament\Admin\Resources\ExerciseCategories\Pages\CreateExerciseCategory;
use App\Filament\Admin\Resources\ExerciseCategories\Pages\EditExerciseCategory;
use App\Filament\Admin\Resources\ExerciseCategories\Pages\ListExerciseCategories;
use App\Filament\Admin\Resources\ExerciseCategories\Pages\ViewExerciseCategory;
use App\Filament\Admin\Resources\ExerciseCategories\Schemas\ExerciseCategoryForm;
use App\Filament\Admin\Resources\ExerciseCategories\Schemas\ExerciseCategoryInfolist;
use App\Filament\Admin\Resources\ExerciseCategories\Tables\ExerciseCategoriesTable;
use App\Models\ExerciseCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExerciseCategoryResource extends Resource
{
    protected static ?string $model = ExerciseCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Exercise Category';

    public static function form(Schema $schema): Schema
    {
        return ExerciseCategoryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExerciseCategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExerciseCategoriesTable::configure($table);
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
            'index' => ListExerciseCategories::route('/'),
            'create' => CreateExerciseCategory::route('/create'),
            'view' => ViewExerciseCategory::route('/{record}'),
            'edit' => EditExerciseCategory::route('/{record}/edit'),
        ];
    }
}
