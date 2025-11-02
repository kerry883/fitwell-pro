<?php

namespace App\Filament\Admin\Resources\FitnessAssessments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FitnessAssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('trainer_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('assessment_date')
                    ->required(),
                TextInput::make('weight')
                    ->numeric(),
                TextInput::make('height')
                    ->numeric(),
                TextInput::make('body_fat_percentage')
                    ->numeric(),
                TextInput::make('bmi')
                    ->numeric(),
                TextInput::make('measurements'),
                TextInput::make('performance_tests'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('assessment_document_url')
                    ->url(),
            ]);
    }
}
