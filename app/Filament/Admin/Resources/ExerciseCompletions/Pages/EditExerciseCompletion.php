<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions\Pages;

use App\Filament\Admin\Resources\ExerciseCompletions\ExerciseCompletionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExerciseCompletion extends EditRecord
{
    protected static string $resource = ExerciseCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
