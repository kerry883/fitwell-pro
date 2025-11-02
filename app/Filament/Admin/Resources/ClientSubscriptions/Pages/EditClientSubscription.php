<?php

namespace App\Filament\Admin\Resources\ClientSubscriptions\Pages;

use App\Filament\Admin\Resources\ClientSubscriptions\ClientSubscriptionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientSubscription extends EditRecord
{
    protected static string $resource = ClientSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
