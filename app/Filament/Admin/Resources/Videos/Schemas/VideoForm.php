<?php

namespace App\Filament\Admin\Resources\Videos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('session_id')
                    ->numeric(),
                TextInput::make('exercise_id')
                    ->numeric(),
                Select::make('video_type')
                    ->options([
            'FORM_CHECK' => 'F o r m  c h e c k',
            'PROGRESS_VIDEO' => 'P r o g r e s s  v i d e o',
            'WORKOUT_COMPLETION' => 'W o r k o u t  c o m p l e t i o n',
            'MEAL_PREP' => 'M e a l  p r e p',
            'CHECK_IN' => 'C h e c k  i n',
            'INJURY_ASSESSMENT' => 'I n j u r y  a s s e s s m e n t',
        ])
                    ->required(),
                TextInput::make('video_url')
                    ->url()
                    ->required(),
                TextInput::make('thumbnail_url')
                    ->url(),
                TextInput::make('duration_seconds')
                    ->numeric(),
                Textarea::make('client_notes')
                    ->columnSpanFull(),
                DatePicker::make('recorded_date'),
                Select::make('review_status')
                    ->options([
            'PENDING' => 'P e n d i n g',
            'IN_REVIEW' => 'I n  r e v i e w',
            'REVIEWED' => 'R e v i e w e d',
            'APPROVED' => 'A p p r o v e d',
            'NEEDS_REVISION' => 'N e e d s  r e v i s i o n',
        ])
                    ->default('PENDING')
                    ->required(),
                DateTimePicker::make('uploaded_at'),
                DateTimePicker::make('reviewed_at'),
            ]);
    }
}
