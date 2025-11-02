<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities\Pages;

use App\Filament\Admin\Resources\TrainerAvailabilities\TrainerAvailabilityResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainerAvailability extends EditRecord
{
    protected static string $resource = TrainerAvailabilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
