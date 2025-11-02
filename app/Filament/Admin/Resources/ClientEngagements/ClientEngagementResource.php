<?php

namespace App\Filament\Admin\Resources\ClientEngagements;

use App\Filament\Admin\Resources\ClientEngagements\Pages\CreateClientEngagement;
use App\Filament\Admin\Resources\ClientEngagements\Pages\EditClientEngagement;
use App\Filament\Admin\Resources\ClientEngagements\Pages\ListClientEngagements;
use App\Filament\Admin\Resources\ClientEngagements\Pages\ViewClientEngagement;
use App\Filament\Admin\Resources\ClientEngagements\Schemas\ClientEngagementForm;
use App\Filament\Admin\Resources\ClientEngagements\Schemas\ClientEngagementInfolist;
use App\Filament\Admin\Resources\ClientEngagements\Tables\ClientEngagementsTable;
use App\Models\ClientEngagement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientEngagementResource extends Resource
{
    protected static ?string $model = ClientEngagement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Engagements';

    public static function form(Schema $schema): Schema
    {
        return ClientEngagementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientEngagementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientEngagementsTable::configure($table);
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
            'index' => ListClientEngagements::route('/'),
            'create' => CreateClientEngagement::route('/create'),
            'view' => ViewClientEngagement::route('/{record}'),
            'edit' => EditClientEngagement::route('/{record}/edit'),
        ];
    }
}
