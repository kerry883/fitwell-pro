<?php

namespace App\Filament\Admin\Resources\ProgramTemplates;

use App\Filament\Admin\Resources\ProgramTemplates\Pages\CreateProgramTemplate;
use App\Filament\Admin\Resources\ProgramTemplates\Pages\EditProgramTemplate;
use App\Filament\Admin\Resources\ProgramTemplates\Pages\ListProgramTemplates;
use App\Filament\Admin\Resources\ProgramTemplates\Pages\ViewProgramTemplate;
use App\Filament\Admin\Resources\ProgramTemplates\Schemas\ProgramTemplateForm;
use App\Filament\Admin\Resources\ProgramTemplates\Schemas\ProgramTemplateInfolist;
use App\Filament\Admin\Resources\ProgramTemplates\Tables\ProgramTemplatesTable;
use App\Models\ProgramTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgramTemplateResource extends Resource
{
    protected static ?string $model = ProgramTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Program Template';

    public static function form(Schema $schema): Schema
    {
        return ProgramTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgramTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramTemplatesTable::configure($table);
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
            'index' => ListProgramTemplates::route('/'),
            'create' => CreateProgramTemplate::route('/create'),
            'view' => ViewProgramTemplate::route('/{record}'),
            'edit' => EditProgramTemplate::route('/{record}/edit'),
        ];
    }
}
