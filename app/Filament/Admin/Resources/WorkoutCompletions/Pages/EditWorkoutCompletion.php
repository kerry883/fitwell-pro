<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions\Pages;

use App\Filament\Admin\Resources\WorkoutCompletions\WorkoutCompletionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkoutCompletion extends EditRecord
{
    protected static string $resource = WorkoutCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
