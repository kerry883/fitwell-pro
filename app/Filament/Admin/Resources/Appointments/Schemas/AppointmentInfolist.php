<?php

namespace App\Filament\Admin\Resources\Appointments\Schemas;

use App\Models\Appointment;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AppointmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainer_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('recurring_pattern_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('session_type')
                    ->badge(),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('scheduled_start')
                    ->dateTime(),
                TextEntry::make('scheduled_end')
                    ->dateTime(),
                TextEntry::make('location')
                    ->placeholder('-'),
                TextEntry::make('meeting_link')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                IconEntry::make('is_recurring')
                    ->boolean(),
                TextEntry::make('cancellation_reason')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Appointment $record): bool => $record->trashed()),
            ]);
    }
}
