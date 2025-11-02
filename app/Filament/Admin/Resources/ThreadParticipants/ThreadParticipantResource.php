<?php

namespace App\Filament\Admin\Resources\ThreadParticipants;

use App\Filament\Admin\Resources\ThreadParticipants\Pages\CreateThreadParticipant;
use App\Filament\Admin\Resources\ThreadParticipants\Pages\EditThreadParticipant;
use App\Filament\Admin\Resources\ThreadParticipants\Pages\ListThreadParticipants;
use App\Filament\Admin\Resources\ThreadParticipants\Pages\ViewThreadParticipant;
use App\Filament\Admin\Resources\ThreadParticipants\Schemas\ThreadParticipantForm;
use App\Filament\Admin\Resources\ThreadParticipants\Schemas\ThreadParticipantInfolist;
use App\Filament\Admin\Resources\ThreadParticipants\Tables\ThreadParticipantsTable;
use App\Models\ThreadParticipant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ThreadParticipantResource extends Resource
{
    protected static ?string $model = ThreadParticipant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Thread Participants';

    public static function form(Schema $schema): Schema
    {
        return ThreadParticipantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ThreadParticipantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThreadParticipantsTable::configure($table);
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
            'index' => ListThreadParticipants::route('/'),
            'create' => CreateThreadParticipant::route('/create'),
            'view' => ViewThreadParticipant::route('/{record}'),
            'edit' => EditThreadParticipant::route('/{record}/edit'),
        ];
    }
}
