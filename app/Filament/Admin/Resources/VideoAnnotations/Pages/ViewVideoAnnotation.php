<?php

namespace App\Filament\Admin\Resources\VideoAnnotations\Pages;

use App\Filament\Admin\Resources\VideoAnnotations\VideoAnnotationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVideoAnnotation extends ViewRecord
{
    protected static string $resource = VideoAnnotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
