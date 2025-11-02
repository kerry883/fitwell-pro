<?php

namespace App\Filament\Admin\Resources\ClientGoals\Pages;

use App\Filament\Admin\Resources\ClientGoals\ClientGoalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditClientGoal extends EditRecord
{
    protected static string $resource = ClientGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
