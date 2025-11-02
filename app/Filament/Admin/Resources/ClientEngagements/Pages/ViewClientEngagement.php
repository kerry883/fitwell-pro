<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Pages;

use App\Filament\Admin\Resources\ClientEngagements\ClientEngagementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientEngagement extends ViewRecord
{
    protected static string $resource = ClientEngagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
