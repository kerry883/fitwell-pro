<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Pages;

use App\Filament\Admin\Resources\WorkoutSessions\WorkoutSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkoutSession extends EditRecord
{
    protected static string $resource = WorkoutSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
