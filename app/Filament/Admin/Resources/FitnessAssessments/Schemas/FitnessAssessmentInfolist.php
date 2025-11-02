<?php

namespace App\Filament\Admin\Resources\FitnessAssessments\Schemas;

use App\Models\FitnessAssessment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FitnessAssessmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('trainer_id')
                    ->numeric(),
                TextEntry::make('assessment_date')
                    ->date(),
                TextEntry::make('weight')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('height')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('body_fat_percentage')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('bmi')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('assessment_document_url')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (FitnessAssessment $record): bool => $record->trashed()),
            ]);
    }
}
