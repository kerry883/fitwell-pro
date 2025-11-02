<?php

namespace App\Filament\Admin\Resources\ProgressEntries\Pages;

use App\Filament\Admin\Resources\ProgressEntries\ProgressEntryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProgressEntry extends CreateRecord
{
    protected static string $resource = ProgressEntryResource::class;
}
