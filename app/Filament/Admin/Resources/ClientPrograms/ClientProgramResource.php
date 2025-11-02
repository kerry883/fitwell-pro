<?php

namespace App\Filament\Admin\Resources\ClientPrograms;

use App\Filament\Admin\Resources\ClientPrograms\Pages\CreateClientProgram;
use App\Filament\Admin\Resources\ClientPrograms\Pages\EditClientProgram;
use App\Filament\Admin\Resources\ClientPrograms\Pages\ListClientPrograms;
use App\Filament\Admin\Resources\ClientPrograms\Pages\ViewClientProgram;
use App\Filament\Admin\Resources\ClientPrograms\Schemas\ClientProgramForm;
use App\Filament\Admin\Resources\ClientPrograms\Schemas\ClientProgramInfolist;
use App\Filament\Admin\Resources\ClientPrograms\Tables\ClientProgramsTable;
use App\Models\ClientProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientProgramResource extends Resource
{
    protected static ?string $model = ClientProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Client Program';

    public static function form(Schema $schema): Schema
    {
        return ClientProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientProgramsTable::configure($table);
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
            'index' => ListClientPrograms::route('/'),
            'create' => CreateClientProgram::route('/create'),
            'view' => ViewClientProgram::route('/{record}'),
            'edit' => EditClientProgram::route('/{record}/edit'),
        ];
    }
}
