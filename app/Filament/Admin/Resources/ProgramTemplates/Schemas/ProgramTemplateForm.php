<?php

namespace App\Filament\Admin\Resources\ProgramTemplates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProgramTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('created_by_trainer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('template_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('program_type')
                    ->options(['WORKOUT' => 'W o r k o u t', 'NUTRITION' => 'N u t r i t i o n', 'HYBRID' => 'H y b r i d'])
                    ->default('WORKOUT')
                    ->required(),
                Select::make('difficulty_level')
                    ->options([
            'BEGINNER' => 'B e g i n n e r',
            'INTERMEDIATE' => 'I n t e r m e d i a t e',
            'ADVANCED' => 'A d v a n c e d',
        ])
                    ->default('BEGINNER')
                    ->required(),
                TextInput::make('duration_weeks')
                    ->required()
                    ->numeric(),
                Toggle::make('is_progressive')
                    ->required(),
                TextInput::make('phase_structure'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
