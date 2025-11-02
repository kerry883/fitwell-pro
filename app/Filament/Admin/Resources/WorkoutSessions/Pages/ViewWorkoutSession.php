<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Pages;

use App\Filament\Admin\Resources\WorkoutSessions\WorkoutSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkoutSession extends ViewRecord
{
    protected static string $resource = WorkoutSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
