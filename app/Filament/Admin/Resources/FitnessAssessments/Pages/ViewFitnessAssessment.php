<?php

namespace App\Filament\Admin\Resources\FitnessAssessments\Pages;

use App\Filament\Admin\Resources\FitnessAssessments\FitnessAssessmentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFitnessAssessment extends ViewRecord
{
    protected static string $resource = FitnessAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
