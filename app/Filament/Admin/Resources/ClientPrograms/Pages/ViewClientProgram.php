<?php

namespace App\Filament\Admin\Resources\ClientPrograms\Pages;

use App\Filament\Admin\Resources\ClientPrograms\ClientProgramResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientProgram extends ViewRecord
{
    protected static string $resource = ClientProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
