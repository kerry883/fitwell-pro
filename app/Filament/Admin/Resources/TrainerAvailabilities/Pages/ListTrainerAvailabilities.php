<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities\Pages;

use App\Filament\Admin\Resources\TrainerAvailabilities\TrainerAvailabilityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainerAvailabilities extends ListRecords
{
    protected static string $resource = TrainerAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
