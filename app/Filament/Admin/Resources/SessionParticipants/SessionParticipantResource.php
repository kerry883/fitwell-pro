<?php

namespace App\Filament\Admin\Resources\SessionParticipants;

use App\Filament\Admin\Resources\SessionParticipants\Pages\CreateSessionParticipant;
use App\Filament\Admin\Resources\SessionParticipants\Pages\EditSessionParticipant;
use App\Filament\Admin\Resources\SessionParticipants\Pages\ListSessionParticipants;
use App\Filament\Admin\Resources\SessionParticipants\Pages\ViewSessionParticipant;
use App\Filament\Admin\Resources\SessionParticipants\Schemas\SessionParticipantForm;
use App\Filament\Admin\Resources\SessionParticipants\Schemas\SessionParticipantInfolist;
use App\Filament\Admin\Resources\SessionParticipants\Tables\SessionParticipantsTable;
use App\Models\SessionParticipant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessionParticipantResource extends Resource
{
    protected static ?string $model = SessionParticipant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Session Participants';

    public static function form(Schema $schema): Schema
    {
        return SessionParticipantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SessionParticipantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SessionParticipantsTable::configure($table);
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
            'index' => ListSessionParticipants::route('/'),
            'create' => CreateSessionParticipant::route('/create'),
            'view' => ViewSessionParticipant::route('/{record}'),
            'edit' => EditSessionParticipant::route('/{record}/edit'),
        ];
    }
}
