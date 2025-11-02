<?php

namespace App\Filament\Admin\Resources\ClientGoals\Pages;

use App\Filament\Admin\Resources\ClientGoals\ClientGoalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClientGoal extends ViewRecord
{
    protected static string $resource = ClientGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
