<?php

namespace App\Filament\Admin\Resources\RecurringPatterns\Pages;

use App\Filament\Admin\Resources\RecurringPatterns\RecurringPatternResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRecurringPattern extends ViewRecord
{
    protected static string $resource = RecurringPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
