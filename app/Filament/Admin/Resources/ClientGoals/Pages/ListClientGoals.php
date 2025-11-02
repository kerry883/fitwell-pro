<?php

namespace App\Filament\Admin\Resources\ClientGoals\Pages;

use App\Filament\Admin\Resources\ClientGoals\ClientGoalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClientGoals extends ListRecords
{
    protected static string $resource = ClientGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
