<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions;

use App\Filament\Admin\Resources\ExerciseCompletions\Pages\CreateExerciseCompletion;
use App\Filament\Admin\Resources\ExerciseCompletions\Pages\EditExerciseCompletion;
use App\Filament\Admin\Resources\ExerciseCompletions\Pages\ListExerciseCompletions;
use App\Filament\Admin\Resources\ExerciseCompletions\Pages\ViewExerciseCompletion;
use App\Filament\Admin\Resources\ExerciseCompletions\Schemas\ExerciseCompletionForm;
use App\Filament\Admin\Resources\ExerciseCompletions\Schemas\ExerciseCompletionInfolist;
use App\Filament\Admin\Resources\ExerciseCompletions\Tables\ExerciseCompletionsTable;
use App\Models\ExerciseCompletion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExerciseCompletionResource extends Resource
{
    protected static ?string $model = ExerciseCompletion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Exercise Completion';

    public static function form(Schema $schema): Schema
    {
        return ExerciseCompletionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExerciseCompletionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExerciseCompletionsTable::configure($table);
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
            'index' => ListExerciseCompletions::route('/'),
            'create' => CreateExerciseCompletion::route('/create'),
            'view' => ViewExerciseCompletion::route('/{record}'),
            'edit' => EditExerciseCompletion::route('/{record}/edit'),
        ];
    }
}
