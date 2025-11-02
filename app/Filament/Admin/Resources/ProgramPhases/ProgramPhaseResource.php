<?php

namespace App\Filament\Admin\Resources\ProgramPhases;

use App\Filament\Admin\Resources\ProgramPhases\Pages\CreateProgramPhase;
use App\Filament\Admin\Resources\ProgramPhases\Pages\EditProgramPhase;
use App\Filament\Admin\Resources\ProgramPhases\Pages\ListProgramPhases;
use App\Filament\Admin\Resources\ProgramPhases\Pages\ViewProgramPhase;
use App\Filament\Admin\Resources\ProgramPhases\Schemas\ProgramPhaseForm;
use App\Filament\Admin\Resources\ProgramPhases\Schemas\ProgramPhaseInfolist;
use App\Filament\Admin\Resources\ProgramPhases\Tables\ProgramPhasesTable;
use App\Models\ProgramPhase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgramPhaseResource extends Resource
{
    protected static ?string $model = ProgramPhase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Program Phase';

    public static function form(Schema $schema): Schema
    {
        return ProgramPhaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgramPhaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramPhasesTable::configure($table);
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
            'index' => ListProgramPhases::route('/'),
            'create' => CreateProgramPhase::route('/create'),
            'view' => ViewProgramPhase::route('/{record}'),
            'edit' => EditProgramPhase::route('/{record}/edit'),
        ];
    }
}
