<?php

namespace App\Filament\Admin\Resources\ClientSubscriptions\Pages;

use App\Filament\Admin\Resources\ClientSubscriptions\ClientSubscriptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientSubscription extends ViewRecord
{
    protected static string $resource = ClientSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
