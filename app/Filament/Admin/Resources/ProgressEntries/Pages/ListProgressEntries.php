<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Pages;

use App\Filament\Admin\Resources\ProgressEntries\ProgressEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProgressEntries extends ListRecords
{
    protected static string $resource = ProgressEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
