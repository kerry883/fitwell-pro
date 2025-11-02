<?php

namespace App\Filament\Admin\Resources\SessionParticipants\Pages;

use App\Filament\Admin\Resources\SessionParticipants\SessionParticipantResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSessionParticipant extends EditRecord
{
    protected static string $resource = SessionParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
