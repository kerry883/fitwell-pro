<?php

namespace App\Filament\Admin\Resources\GroupSessions\Pages;

use App\Filament\Admin\Resources\GroupSessions\GroupSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroupSessions extends ListRecords
{
    protected static string $resource = GroupSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
