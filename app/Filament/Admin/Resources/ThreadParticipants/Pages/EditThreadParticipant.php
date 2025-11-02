<?php

namespace App\Filament\Admin\Resources\ThreadParticipants\Pages;

use App\Filament\Admin\Resources\ThreadParticipants\ThreadParticipantResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditThreadParticipant extends EditRecord
{
    protected static string $resource = ThreadParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
