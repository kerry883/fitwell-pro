<?php

namespace App\Filament\Admin\Resources\RecurringPatterns\Pages;

use App\Filament\Admin\Resources\RecurringPatterns\RecurringPatternResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRecurringPattern extends EditRecord
{
    protected static string $resource = RecurringPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
