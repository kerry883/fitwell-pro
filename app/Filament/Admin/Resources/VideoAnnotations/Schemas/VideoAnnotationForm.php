<?php

namespace App\Filament\Admin\Resources\VideoAnnotations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VideoAnnotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('feedback_id')
                    ->required()
                    ->numeric(),
                TextInput::make('timestamp_seconds')
                    ->required()
                    ->numeric(),
                Textarea::make('annotation_text')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('position_data'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
