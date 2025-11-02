<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities\Pages;

use App\Filament\Admin\Resources\TrainerAvailabilities\TrainerAvailabilityResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainerAvailability extends ViewRecord
{
    protected static string $resource = TrainerAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
