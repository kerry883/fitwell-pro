<?php

namespace App\Filament\Admin\Resources\SessionExercises\Pages;

use App\Filament\Admin\Resources\SessionExercises\SessionExerciseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessionExercises extends ListRecords
{
    protected static string $resource = SessionExerciseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
