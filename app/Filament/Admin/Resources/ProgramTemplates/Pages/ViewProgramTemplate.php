<?php

namespace App\Filament\Admin\Resources\ProgramTemplates\Pages;

use App\Filament\Admin\Resources\ProgramTemplates\ProgramTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgramTemplate extends ViewRecord
{
    protected static string $resource = ProgramTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
