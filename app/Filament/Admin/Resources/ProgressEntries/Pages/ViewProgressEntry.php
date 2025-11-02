<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Pages;

use App\Filament\Admin\Resources\ProgressEntries\ProgressEntryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgressEntry extends ViewRecord
{
    protected static string $resource = ProgressEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
