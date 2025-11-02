<?php

namespace App\Filament\Admin\Resources\SessionExercises\Pages;

use App\Filament\Admin\Resources\SessionExercises\SessionExerciseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSessionExercise extends EditRecord
{
    protected static string $resource = SessionExerciseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
