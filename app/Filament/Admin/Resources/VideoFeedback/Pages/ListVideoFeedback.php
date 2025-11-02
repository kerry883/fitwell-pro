<?php

namespace App\Filament\Admin\Resources\VideoFeedback\Pages;

use App\Filament\Admin\Resources\VideoFeedback\VideoFeedbackResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoFeedback extends ListRecords
{
    protected static string $resource = VideoFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
