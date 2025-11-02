<?php

namespace App\Filament\Admin\Resources\SessionParticipants\Pages;

use App\Filament\Admin\Resources\SessionParticipants\SessionParticipantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSessionParticipant extends ViewRecord
{
    protected static string $resource = SessionParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
