<?php

namespace App\Filament\Admin\Resources\VideoFeedback\Pages;

use App\Filament\Admin\Resources\VideoFeedback\VideoFeedbackResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoFeedback extends EditRecord
{
    protected static string $resource = VideoFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
