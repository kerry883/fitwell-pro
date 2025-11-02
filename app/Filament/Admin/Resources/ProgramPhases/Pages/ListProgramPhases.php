<?php

namespace App\Filament\Admin\Resources\ProgramPhases\Pages;

use App\Filament\Admin\Resources\ProgramPhases\ProgramPhaseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgramPhases extends ListRecords
{
    protected static string $resource = ProgramPhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
