<?php

namespace App\Filament\Admin\Resources\AutomatedMessages\Pages;

use App\Filament\Admin\Resources\AutomatedMessages\AutomatedMessageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAutomatedMessage extends ViewRecord
{
    protected static string $resource = AutomatedMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
