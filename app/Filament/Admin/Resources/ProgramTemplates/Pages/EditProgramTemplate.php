<?php

namespace App\Filament\Admin\Resources\ProgramTemplates\Pages;

use App\Filament\Admin\Resources\ProgramTemplates\ProgramTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgramTemplate extends EditRecord
{
    protected static string $resource = ProgramTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
