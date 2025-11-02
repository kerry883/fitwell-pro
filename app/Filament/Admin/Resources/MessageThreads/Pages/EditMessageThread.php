<?php

namespace App\Filament\Admin\Resources\MessageThreads\Pages;

use App\Filament\Admin\Resources\MessageThreads\MessageThreadResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMessageThread extends EditRecord
{
    protected static string $resource = MessageThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
