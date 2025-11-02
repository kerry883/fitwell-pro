<?php

namespace App\Filament\Admin\Resources\RecurringPatterns\Pages;

use App\Filament\Admin\Resources\RecurringPatterns\RecurringPatternResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecurringPatterns extends ListRecords
{
    protected static string $resource = RecurringPatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
