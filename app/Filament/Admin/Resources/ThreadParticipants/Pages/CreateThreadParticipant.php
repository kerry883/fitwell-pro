<?php

namespace App\Filament\Admin\Resources\ThreadParticipants\Pages;

use App\Filament\Admin\Resources\ThreadParticipants\ThreadParticipantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateThreadParticipant extends CreateRecord
{
    protected static string $resource = ThreadParticipantResource::class;
}
