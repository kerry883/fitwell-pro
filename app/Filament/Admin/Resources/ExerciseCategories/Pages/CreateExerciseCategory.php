<?php

namespace App\Filament\Admin\Resources\ExerciseCategories\Pages;

use App\Filament\Admin\Resources\ExerciseCategories\ExerciseCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExerciseCategory extends CreateRecord
{
    protected static string $resource = ExerciseCategoryResource::class;
}
