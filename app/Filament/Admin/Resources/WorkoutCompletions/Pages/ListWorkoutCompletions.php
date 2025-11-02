<?php

namespace App\Filament\Admin\Resources\WorkoutCompletions\Pages;

use App\Filament\Admin\Resources\WorkoutCompletions\WorkoutCompletionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutCompletions extends ListRecords
{
    protected static string $resource = WorkoutCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
