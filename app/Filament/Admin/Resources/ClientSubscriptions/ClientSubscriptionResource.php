<?php

namespace App\Filament\Admin\Resources\ClientSubscriptions;

use App\Filament\Admin\Resources\ClientSubscriptions\Pages\CreateClientSubscription;
use App\Filament\Admin\Resources\ClientSubscriptions\Pages\EditClientSubscription;
use App\Filament\Admin\Resources\ClientSubscriptions\Pages\ListClientSubscriptions;
use App\Filament\Admin\Resources\ClientSubscriptions\Pages\ViewClientSubscription;
use App\Filament\Admin\Resources\ClientSubscriptions\Schemas\ClientSubscriptionForm;
use App\Filament\Admin\Resources\ClientSubscriptions\Schemas\ClientSubscriptionInfolist;
use App\Filament\Admin\Resources\ClientSubscriptions\Tables\ClientSubscriptionsTable;
use App\Models\ClientSubscription;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientSubscriptionResource extends Resource
{
    protected static ?string $model = ClientSubscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Subscriptions';

    public static function form(Schema $schema): Schema
    {
        return ClientSubscriptionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClientSubscriptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientSubscriptionsTable::configure($table);
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
            'index' => ListClientSubscriptions::route('/'),
            'create' => CreateClientSubscription::route('/create'),
            'view' => ViewClientSubscription::route('/{record}'),
            'edit' => EditClientSubscription::route('/{record}/edit'),
        ];
    }
}
