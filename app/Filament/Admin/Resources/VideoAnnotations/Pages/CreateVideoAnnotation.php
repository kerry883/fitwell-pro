<?php

namespace App\Filament\Admin\Resources\VideoAnnotations\Pages;

use App\Filament\Admin\Resources\VideoAnnotations\VideoAnnotationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideoAnnotation extends CreateRecord
{
    protected static string $resource = VideoAnnotationResource::class;
}
