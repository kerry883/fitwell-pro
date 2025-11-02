<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Pages;

use App\Filament\Admin\Resources\WorkoutSessions\WorkoutSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkoutSessions extends ListRecords
{
    protected static string $resource = WorkoutSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
