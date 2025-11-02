<?php

namespace App\Filament\Admin\Resources\ExerciseCategories\Pages;

use App\Filament\Admin\Resources\ExerciseCategories\ExerciseCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExerciseCategory extends ViewRecord
{
    protected static string $resource = ExerciseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
