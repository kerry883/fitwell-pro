<?php

namespace App\Filament\Admin\Resources\AutomatedMessages\Pages;

use App\Filament\Admin\Resources\AutomatedMessages\AutomatedMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAutomatedMessage extends EditRecord
{
    protected static string $resource = AutomatedMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
