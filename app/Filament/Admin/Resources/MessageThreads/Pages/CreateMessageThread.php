<?php

namespace App\Filament\Admin\Resources\MessageThreads\Pages;

use App\Filament\Admin\Resources\MessageThreads\MessageThreadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMessageThread extends CreateRecord
{
    protected static string $resource = MessageThreadResource::class;
}
