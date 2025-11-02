<?php

namespace App\Filament\Admin\Resources\ClientProfiles;

use App\Filament\Admin\Resources\ClientProfiles\Pages\CreateClientProfile;
use App\Filament\Admin\Resources\ClientProfiles\Pages\EditClientProfile;
use App\Filament\Admin\Resources\ClientProfiles\Pages\ListClientProfiles;
use App\Filament\Admin\Resources\ClientProfiles\Schemas\ClientProfileForm;
use App\Filament\Admin\Resources\ClientProfiles\Tables\ClientProfilesTable;
use App\Models\ClientProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientProfileResource extends Resource
{
    protected static ?string $model = ClientProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = '--generate && php artisan make:filament-resource EmergencyContact --generate && php artisan make:filament-resource';

    public static function form(Schema $schema): Schema
    {
        return ClientProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientProfilesTable::configure($table);
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
            'index' => ListClientProfiles::route('/'),
            'create' => CreateClientProfile::route('/create'),
            'edit' => EditClientProfile::route('/{record}/edit'),
        ];
    }
}
