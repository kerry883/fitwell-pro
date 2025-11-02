<?php

namespace App\Filament\Admin\Resources\VideoAnnotations\Pages;

use App\Filament\Admin\Resources\VideoAnnotations\VideoAnnotationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoAnnotation extends EditRecord
{
    protected static string $resource = VideoAnnotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
