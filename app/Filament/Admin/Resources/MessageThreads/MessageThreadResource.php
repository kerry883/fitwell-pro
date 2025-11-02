<?php

namespace App\Filament\Admin\Resources\MessageThreads;

use App\Filament\Admin\Resources\MessageThreads\Pages\CreateMessageThread;
use App\Filament\Admin\Resources\MessageThreads\Pages\EditMessageThread;
use App\Filament\Admin\Resources\MessageThreads\Pages\ListMessageThreads;
use App\Filament\Admin\Resources\MessageThreads\Pages\ViewMessageThread;
use App\Filament\Admin\Resources\MessageThreads\Schemas\MessageThreadForm;
use App\Filament\Admin\Resources\MessageThreads\Schemas\MessageThreadInfolist;
use App\Filament\Admin\Resources\MessageThreads\Tables\MessageThreadsTable;
use App\Models\MessageThread;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MessageThreadResource extends Resource
{
    protected static ?string $model = MessageThread::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Messages Threads';

    public static function form(Schema $schema): Schema
    {
        return MessageThreadForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MessageThreadInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MessageThreadsTable::configure($table);
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
            'index' => ListMessageThreads::route('/'),
            'create' => CreateMessageThread::route('/create'),
            'view' => ViewMessageThread::route('/{record}'),
            'edit' => EditMessageThread::route('/{record}/edit'),
        ];
    }
}
