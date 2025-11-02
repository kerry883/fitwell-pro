<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions;

use App\Filament\Admin\Resources\WorkoutCompletions\Pages\CreateWorkoutCompletion;
use App\Filament\Admin\Resources\WorkoutCompletions\Pages\EditWorkoutCompletion;
use App\Filament\Admin\Resources\WorkoutCompletions\Pages\ListWorkoutCompletions;
use App\Filament\Admin\Resources\WorkoutCompletions\Pages\ViewWorkoutCompletion;
use App\Filament\Admin\Resources\WorkoutCompletions\Schemas\WorkoutCompletionForm;
use App\Filament\Admin\Resources\WorkoutCompletions\Schemas\WorkoutCompletionInfolist;
use App\Filament\Admin\Resources\WorkoutCompletions\Tables\WorkoutCompletionsTable;
use App\Models\WorkoutCompletion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkoutCompletionResource extends Resource
{
    protected static ?string $model = WorkoutCompletion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Workout Completion';

    public static function form(Schema $schema): Schema
    {
        return WorkoutCompletionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkoutCompletionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkoutCompletionsTable::configure($table);
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
            'index' => ListWorkoutCompletions::route('/'),
            'create' => CreateWorkoutCompletion::route('/create'),
            'view' => ViewWorkoutCompletion::route('/{record}'),
            'edit' => EditWorkoutCompletion::route('/{record}/edit'),
        ];
    }
}
