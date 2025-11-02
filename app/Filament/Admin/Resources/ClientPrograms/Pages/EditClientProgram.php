<?php

namespace App\Filament\Admin\Resources\ClientPrograms\Pages;

use App\Filament\Admin\Resources\ClientPrograms\ClientProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientProgram extends EditRecord
{
    protected static string $resource = ClientProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
