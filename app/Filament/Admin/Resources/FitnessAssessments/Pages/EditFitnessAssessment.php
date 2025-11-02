<?php

namespace App\Filament\Admin\Resources\FitnessAssessments\Pages;

use App\Filament\Admin\Resources\FitnessAssessments\FitnessAssessmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFitnessAssessment extends EditRecord
{
    protected static string $resource = FitnessAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
