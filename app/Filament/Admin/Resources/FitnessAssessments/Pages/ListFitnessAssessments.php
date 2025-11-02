<?php

namespace App\Filament\Admin\Resources\FitnessAssessments\Pages;

use App\Filament\Admin\Resources\FitnessAssessments\FitnessAssessmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFitnessAssessments extends ListRecords
{
    protected static string $resource = FitnessAssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
