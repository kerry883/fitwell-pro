<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions\Pages;

use App\Filament\Admin\Resources\ExerciseCompletions\ExerciseCompletionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExerciseCompletion extends ViewRecord
{
    protected static string $resource = ExerciseCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
