<?php

namespace App\Filament\Admin\Resources\GroupSessions;

use App\Filament\Admin\Resources\GroupSessions\Pages\CreateGroupSession;
use App\Filament\Admin\Resources\GroupSessions\Pages\EditGroupSession;
use App\Filament\Admin\Resources\GroupSessions\Pages\ListGroupSessions;
use App\Filament\Admin\Resources\GroupSessions\Pages\ViewGroupSession;
use App\Filament\Admin\Resources\GroupSessions\Schemas\GroupSessionForm;
use App\Filament\Admin\Resources\GroupSessions\Schemas\GroupSessionInfolist;
use App\Filament\Admin\Resources\GroupSessions\Tables\GroupSessionsTable;
use App\Models\GroupSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GroupSessionResource extends Resource
{
    protected static ?string $model = GroupSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Group Session';

    public static function form(Schema $schema): Schema
    {
        return GroupSessionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GroupSessionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupSessionsTable::configure($table);
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
            'index' => ListGroupSessions::route('/'),
            'create' => CreateGroupSession::route('/create'),
            'view' => ViewGroupSession::route('/{record}'),
            'edit' => EditGroupSession::route('/{record}/edit'),
        ];
    }
}
