<?php

namespace App\Filament\Admin\Resources\WorkoutSessions;

use App\Filament\Admin\Resources\WorkoutSessions\Pages\CreateWorkoutSession;
use App\Filament\Admin\Resources\WorkoutSessions\Pages\EditWorkoutSession;
use App\Filament\Admin\Resources\WorkoutSessions\Pages\ListWorkoutSessions;
use App\Filament\Admin\Resources\WorkoutSessions\Pages\ViewWorkoutSession;
use App\Filament\Admin\Resources\WorkoutSessions\Schemas\WorkoutSessionForm;
use App\Filament\Admin\Resources\WorkoutSessions\Schemas\WorkoutSessionInfolist;
use App\Filament\Admin\Resources\WorkoutSessions\Tables\WorkoutSessionsTable;
use App\Models\WorkoutSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkoutSessionResource extends Resource
{
    protected static ?string $model = WorkoutSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Workout Session';

    public static function form(Schema $schema): Schema
    {
        return WorkoutSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkoutSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkoutSessionsTable::configure($table);
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
            'index' => ListWorkoutSessions::route('/'),
            'create' => CreateWorkoutSession::route('/create'),
            'view' => ViewWorkoutSession::route('/{record}'),
            'edit' => EditWorkoutSession::route('/{record}/edit'),
        ];
    }
}
