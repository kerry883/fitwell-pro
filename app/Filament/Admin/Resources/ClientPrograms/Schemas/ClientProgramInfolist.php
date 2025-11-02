<?php

namespace App\Filament\Admin\Resources\ClientPrograms\Schemas;

use App\Models\ClientProgram;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('template_id')
                    ->numeric(),
                TextEntry::make('assigned_by_trainer_id')
                    ->numeric(),
                TextEntry::make('program_name'),
                TextEntry::make('assignment_type')
                    ->badge(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('current_week')
                    ->numeric(),
                TextEntry::make('current_phase')
                    ->numeric(),
                IconEntry::make('auto_advance')
                    ->boolean(),
                TextEntry::make('assigned_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ClientProgram $record): bool => $record->trashed()),
            ]);
    }
}
