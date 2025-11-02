<?php

namespace App\Filament\Admin\Resources\ProgressPhotos\Pages;

use App\Filament\Admin\Resources\ProgressPhotos\ProgressPhotoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProgressPhoto extends EditRecord
{
    protected static string $resource = ProgressPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
