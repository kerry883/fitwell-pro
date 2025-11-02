<?php

namespace App\Filament\Admin\Resources\ExerciseCompletions\Pages;

use App\Filament\Admin\Resources\ExerciseCompletions\ExerciseCompletionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExerciseCompletions extends ListRecords
{
    protected static string $resource = ExerciseCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
