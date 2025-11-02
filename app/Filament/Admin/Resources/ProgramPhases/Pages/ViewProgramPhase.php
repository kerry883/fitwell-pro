<?php

namespace App\Filament\Admin\Resources\ProgramPhases\Pages;

use App\Filament\Admin\Resources\ProgramPhases\ProgramPhaseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgramPhase extends ViewRecord
{
    protected static string $resource = ProgramPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
