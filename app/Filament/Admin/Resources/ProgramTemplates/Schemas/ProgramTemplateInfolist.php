<?php

namespace App\Filament\Admin\Resources\ProgramTemplates\Schemas;

use App\Models\ProgramTemplate;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProgramTemplateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_by_trainer_id')
                    ->numeric(),
                TextEntry::make('template_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('program_type')
                    ->badge(),
                TextEntry::make('difficulty_level')
                    ->badge(),
                TextEntry::make('duration_weeks')
                    ->numeric(),
                IconEntry::make('is_progressive')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ProgramTemplate $record): bool => $record->trashed()),
            ]);
    }
}
