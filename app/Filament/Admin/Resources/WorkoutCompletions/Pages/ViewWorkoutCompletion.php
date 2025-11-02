<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions\Pages;

use App\Filament\Admin\Resources\WorkoutCompletions\WorkoutCompletionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkoutCompletion extends ViewRecord
{
    protected static string $resource = WorkoutCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
