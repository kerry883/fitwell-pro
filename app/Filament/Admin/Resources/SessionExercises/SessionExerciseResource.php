<?php

namespace App\Filament\Admin\Resources\SessionExercises;

use App\Filament\Admin\Resources\SessionExercises\Pages\CreateSessionExercise;
use App\Filament\Admin\Resources\SessionExercises\Pages\EditSessionExercise;
use App\Filament\Admin\Resources\SessionExercises\Pages\ListSessionExercises;
use App\Filament\Admin\Resources\SessionExercises\Pages\ViewSessionExercise;
use App\Filament\Admin\Resources\SessionExercises\Schemas\SessionExerciseForm;
use App\Filament\Admin\Resources\SessionExercises\Schemas\SessionExerciseInfolist;
use App\Filament\Admin\Resources\SessionExercises\Tables\SessionExercisesTable;
use App\Models\SessionExercise;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessionExerciseResource extends Resource
{
    protected static ?string $model = SessionExercise::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Session Exercise';

    public static function form(Schema $schema): Schema
    {
        return SessionExerciseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionExerciseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionExercisesTable::configure($table);
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
            'index' => ListSessionExercises::route('/'),
            'create' => CreateSessionExercise::route('/create'),
            'view' => ViewSessionExercise::route('/{record}'),
            'edit' => EditSessionExercise::route('/{record}/edit'),
        ];
    }
}
