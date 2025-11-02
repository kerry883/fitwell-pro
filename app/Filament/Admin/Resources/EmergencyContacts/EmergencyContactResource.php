<?php

namespace App\Filament\Admin\Resources\EmergencyContacts;

use App\Filament\Admin\Resources\EmergencyContacts\Pages\CreateEmergencyContact;
use App\Filament\Admin\Resources\EmergencyContacts\Pages\EditEmergencyContact;
use App\Filament\Admin\Resources\EmergencyContacts\Pages\ListEmergencyContacts;
use App\Filament\Admin\Resources\EmergencyContacts\Pages\ViewEmergencyContact;
use App\Filament\Admin\Resources\EmergencyContacts\Schemas\EmergencyContactForm;
use App\Filament\Admin\Resources\EmergencyContacts\Schemas\EmergencyContactInfolist;
use App\Filament\Admin\Resources\EmergencyContacts\Tables\EmergencyContactsTable;
use App\Models\EmergencyContact;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EmergencyContactResource extends Resource
{
    protected static ?string $model = EmergencyContact::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Emmergency Contacts';

    public static function form(Schema $schema): Schema
    {
        return EmergencyContactForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmergencyContactInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmergencyContactsTable::configure($table);
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
            'index' => ListEmergencyContacts::route('/'),
            'create' => CreateEmergencyContact::route('/create'),
            'view' => ViewEmergencyContact::route('/{record}'),
            'edit' => EditEmergencyContact::route('/{record}/edit'),
        ];
    }
}
