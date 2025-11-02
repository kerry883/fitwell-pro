<?php

namespace App\Filament\Admin\Resources\MessageThreads\Pages;

use App\Filament\Admin\Resources\MessageThreads\MessageThreadResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMessageThread extends ViewRecord
{
    protected static string $resource = MessageThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
