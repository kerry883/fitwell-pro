<?php

namespace App\Filament\Admin\Resources\ProgramTemplates\Pages;

use App\Filament\Admin\Resources\ProgramTemplates\ProgramTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgramTemplates extends ListRecords
{
    protected static string $resource = ProgramTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
