<?php

namespace App\Filament\Admin\Resources\SessionExercises\Pages;

use App\Filament\Admin\Resources\SessionExercises\SessionExerciseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSessionExercise extends ViewRecord
{
    protected static string $resource = SessionExerciseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
