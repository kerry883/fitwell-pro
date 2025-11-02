<?php

namespace App\Filament\Admin\Resources\ClientGoals\Pages;

use App\Filament\Admin\Resources\ClientGoals\ClientGoalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientGoal extends CreateRecord
{
    protected static string $resource = ClientGoalResource::class;
}
