<?php

namespace App\Filament\Admin\Resources\Exercises\Pages;

use App\Filament\Admin\Resources\Exercises\ExerciseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExercise extends ViewRecord
{
    protected static string $resource = ExerciseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
