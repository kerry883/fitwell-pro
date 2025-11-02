<?php

namespace App\Filament\Admin\Resources\WorkoutSessions\Pages;

use App\Filament\Admin\Resources\WorkoutSessions\WorkoutSessionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkoutSession extends CreateRecord
{
    protected static string $resource = WorkoutSessionResource::class;
}
