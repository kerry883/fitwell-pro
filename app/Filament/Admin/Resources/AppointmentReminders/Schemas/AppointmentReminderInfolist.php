<?php

namespace App\Filament\Admin\Resources\AppointmentReminders\Schemas;

use App\Models\AppointmentReminder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AppointmentReminderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('appointment_id')
                    ->numeric(),
                TextEntry::make('reminder_type')
                    ->badge(),
                TextEntry::make('minutes_before')
                    ->numeric(),
                IconEntry::make('is_sent')
                    ->boolean(),
                TextEntry::make('sent_at')
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
                    ->visible(fn (AppointmentReminder $record): bool => $record->trashed()),
            ]);
    }
}
