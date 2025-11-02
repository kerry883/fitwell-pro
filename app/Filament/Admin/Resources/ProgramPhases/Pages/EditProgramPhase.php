<?php

namespace App\Filament\Admin\Resources\ProgramPhases\Pages;

use App\Filament\Admin\Resources\ProgramPhases\ProgramPhaseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgramPhase extends EditRecord
{
    protected static string $resource = ProgramPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
