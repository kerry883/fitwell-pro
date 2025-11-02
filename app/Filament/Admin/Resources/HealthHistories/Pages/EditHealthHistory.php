<?php

namespace App\Filament\Admin\Resources\HealthHistories\Pages;

use App\Filament\Admin\Resources\HealthHistories\HealthHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHealthHistory extends EditRecord
{
    protected static string $resource = HealthHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
