<?php

namespace App\Filament\Admin\Resources\ProgressEntries;

use App\Filament\Admin\Resources\ProgressEntries\Pages\CreateProgressEntry;
use App\Filament\Admin\Resources\ProgressEntries\Pages\EditProgressEntry;
use App\Filament\Admin\Resources\ProgressEntries\Pages\ListProgressEntries;
use App\Filament\Admin\Resources\ProgressEntries\Pages\ViewProgressEntry;
use App\Filament\Admin\Resources\ProgressEntries\Schemas\ProgressEntryForm;
use App\Filament\Admin\Resources\ProgressEntries\Schemas\ProgressEntryInfolist;
use App\Filament\Admin\Resources\ProgressEntries\Tables\ProgressEntriesTable;
use App\Models\ProgressEntry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgressEntryResource extends Resource
{
    protected static ?string $model = ProgressEntry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Progress Entries';

    public static function form(Schema $schema): Schema
    {
        return ProgressEntryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgressEntryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgressEntriesTable::configure($table);
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
            'index' => ListProgressEntries::route('/'),
            'create' => CreateProgressEntry::route('/create'),
            'view' => ViewProgressEntry::route('/{record}'),
            'edit' => EditProgressEntry::route('/{record}/edit'),
        ];
    }
}
