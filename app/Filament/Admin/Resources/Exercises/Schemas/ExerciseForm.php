<?php

namespace App\Filament\Admin\Resources\Exercises\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExerciseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('created_by_trainer_id')
                    ->numeric(),
                TextInput::make('category_id')
                    ->numeric(),
                TextInput::make('exercise_name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('instructions')
                    ->columnSpanFull(),
                Select::make('difficulty_level')
                    ->options([
            'BEGINNER' => 'B e g i n n e r',
            'INTERMEDIATE' => 'I n t e r m e d i a t e',
            'ADVANCED' => 'A d v a n c e d',
        ])
                    ->default('BEGINNER')
                    ->required(),
                TextInput::make('muscle_groups'),
                TextInput::make('equipment_needed'),
                TextInput::make('video_demo_url')
                    ->url(),
                FileUpload::make('image_url')
                    ->image(),
                TextInput::make('alternatives'),
                Toggle::make('is_custom')
                    ->required(),
            ]);
    }
}
