<?php

namespace App\Filament\Admin\Resources\VideoAnnotations\Pages;

use App\Filament\Admin\Resources\VideoAnnotations\VideoAnnotationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoAnnotations extends ListRecords
{
    protected static string $resource = VideoAnnotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
