<?php

namespace App\Filament\Admin\Resources\AutomatedMessages\Pages;

use App\Filament\Admin\Resources\AutomatedMessages\AutomatedMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAutomatedMessages extends ListRecords
{
    protected static string $resource = AutomatedMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
