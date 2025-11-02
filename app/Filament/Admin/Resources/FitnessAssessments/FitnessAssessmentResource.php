<?php

namespace App\Filament\Admin\Resources\FitnessAssessments;

use App\Filament\Admin\Resources\FitnessAssessments\Pages\CreateFitnessAssessment;
use App\Filament\Admin\Resources\FitnessAssessments\Pages\EditFitnessAssessment;
use App\Filament\Admin\Resources\FitnessAssessments\Pages\ListFitnessAssessments;
use App\Filament\Admin\Resources\FitnessAssessments\Pages\ViewFitnessAssessment;
use App\Filament\Admin\Resources\FitnessAssessments\Schemas\FitnessAssessmentForm;
use App\Filament\Admin\Resources\FitnessAssessments\Schemas\FitnessAssessmentInfolist;
use App\Filament\Admin\Resources\FitnessAssessments\Tables\FitnessAssessmentsTable;
use App\Models\FitnessAssessment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FitnessAssessmentResource extends Resource
{
    protected static ?string $model = FitnessAssessment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Fitness Assessment';

    public static function form(Schema $schema): Schema
    {
        return FitnessAssessmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FitnessAssessmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FitnessAssessmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFitnessAssessments::route('/'),
            'create' => CreateFitnessAssessment::route('/create'),
            'view' => ViewFitnessAssessment::route('/{record}'),
            'edit' => EditFitnessAssessment::route('/{record}/edit'),
        ];
    }
}
