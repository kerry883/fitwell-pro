<?php

namespace App\Filament\Admin\Resources\ClientSubscriptions\Pages;

use App\Filament\Admin\Resources\ClientSubscriptions\ClientSubscriptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientSubscriptions extends ListRecords
{
    protected static string $resource = ClientSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
