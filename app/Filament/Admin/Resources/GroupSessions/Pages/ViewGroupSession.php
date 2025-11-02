<?php

namespace App\Filament\Admin\Resources\GroupSessions\Pages;

use App\Filament\Admin\Resources\GroupSessions\GroupSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupSession extends ViewRecord
{
    protected static string $resource = GroupSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
