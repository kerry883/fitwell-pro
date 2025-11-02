<?php

namespace App\Filament\Admin\Resources\ProgramPhases\Schemas;

use App\Models\ProgramPhase;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProgramPhaseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('template_id')
                    ->numeric(),
                TextEntry::make('phase_number')
                    ->numeric(),
                TextEntry::make('phase_name'),
                TextEntry::make('phase_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('duration_weeks')
                    ->numeric(),
                TextEntry::make('sort_order')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ProgramPhase $record): bool => $record->trashed()),
            ]);
    }
}
