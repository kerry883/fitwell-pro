<?php

namespace App\Filament\Admin\Resources\ProgressPhotos\Pages;

use App\Filament\Admin\Resources\ProgressPhotos\ProgressPhotoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProgressPhoto extends ViewRecord
{
    protected static string $resource = ProgressPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
