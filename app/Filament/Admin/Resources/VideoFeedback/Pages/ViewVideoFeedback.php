<?php

namespace App\Filament\Admin\Resources\VideoFeedback\Pages;

use App\Filament\Admin\Resources\VideoFeedback\VideoFeedbackResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVideoFeedback extends ViewRecord
{
    protected static string $resource = VideoFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
