<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Pages;

use App\Filament\Admin\Resources\ProgressEntries\ProgressEntryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgressEntry extends EditRecord
{
    protected static string $resource = ProgressEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
