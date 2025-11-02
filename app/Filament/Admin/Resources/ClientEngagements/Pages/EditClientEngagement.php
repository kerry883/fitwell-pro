<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Pages;

use App\Filament\Admin\Resources\ClientEngagements\ClientEngagementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientEngagement extends EditRecord
{
    protected static string $resource = ClientEngagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
