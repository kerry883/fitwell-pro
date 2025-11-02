<?php

namespace App\Filament\Admin\Resources\AutomatedMessages;

use App\Filament\Admin\Resources\AutomatedMessages\Pages\CreateAutomatedMessage;
use App\Filament\Admin\Resources\AutomatedMessages\Pages\EditAutomatedMessage;
use App\Filament\Admin\Resources\AutomatedMessages\Pages\ListAutomatedMessages;
use App\Filament\Admin\Resources\AutomatedMessages\Pages\ViewAutomatedMessage;
use App\Filament\Admin\Resources\AutomatedMessages\Schemas\AutomatedMessageForm;
use App\Filament\Admin\Resources\AutomatedMessages\Schemas\AutomatedMessageInfolist;
use App\Filament\Admin\Resources\AutomatedMessages\Tables\AutomatedMessagesTable;
use App\Models\AutomatedMessage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AutomatedMessageResource extends Resource
{
    protected static ?string $model = AutomatedMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Automated Messages';

    public static function form(Schema $schema): Schema
    {
        return AutomatedMessageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AutomatedMessageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AutomatedMessagesTable::configure($table);
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
            'index' => ListAutomatedMessages::route('/'),
            'create' => CreateAutomatedMessage::route('/create'),
            'view' => ViewAutomatedMessage::route('/{record}'),
            'edit' => EditAutomatedMessage::route('/{record}/edit'),
        ];
    }
}
