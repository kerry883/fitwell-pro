<?php

namespace App\Filament\Admin\Resources\ThreadParticipants\Pages;

use App\Filament\Admin\Resources\ThreadParticipants\ThreadParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListThreadParticipants extends ListRecords
{
    protected static string $resource = ThreadParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
