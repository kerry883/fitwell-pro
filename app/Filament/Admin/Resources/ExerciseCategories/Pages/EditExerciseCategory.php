<?php

namespace App\Filament\Admin\Resources\ExerciseCategories\Pages;

use App\Filament\Admin\Resources\ExerciseCategories\ExerciseCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExerciseCategory extends EditRecord
{
    protected static string $resource = ExerciseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
