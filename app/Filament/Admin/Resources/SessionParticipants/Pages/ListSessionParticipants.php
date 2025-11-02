<?php

namespace App\Filament\Admin\Resources\SessionParticipants\Pages;

use App\Filament\Admin\Resources\SessionParticipants\SessionParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessionParticipants extends ListRecords
{
    protected static string $resource = SessionParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
