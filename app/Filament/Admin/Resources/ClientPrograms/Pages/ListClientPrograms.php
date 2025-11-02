<?php

namespace App\Filament\Admin\Resources\ClientPrograms\Pages;

use App\Filament\Admin\Resources\ClientPrograms\ClientProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientPrograms extends ListRecords
{
    protected static string $resource = ClientProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
