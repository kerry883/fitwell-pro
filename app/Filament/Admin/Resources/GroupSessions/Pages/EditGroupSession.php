<?php

namespace App\Filament\Admin\Resources\GroupSessions\Pages;

use App\Filament\Admin\Resources\GroupSessions\GroupSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGroupSession extends EditRecord
{
    protected static string $resource = GroupSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
