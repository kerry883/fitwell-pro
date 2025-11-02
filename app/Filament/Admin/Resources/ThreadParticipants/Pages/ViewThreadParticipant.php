<?php

namespace App\Filament\Admin\Resources\ThreadParticipants\Pages;

use App\Filament\Admin\Resources\ThreadParticipants\ThreadParticipantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewThreadParticipant extends ViewRecord
{
    protected static string $resource = ThreadParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
