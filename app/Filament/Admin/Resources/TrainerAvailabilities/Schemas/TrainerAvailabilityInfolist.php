<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities\Schemas;

use App\Models\TrainerAvailability;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TrainerAvailabilityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('trainer_id')
                    ->numeric(),
                TextEntry::make('day_of_week')
                    ->badge(),
                TextEntry::make('start_time')
                    ->time(),
                TextEntry::make('end_time')
                    ->time(),
                IconEntry::make('is_recurring')
                    ->boolean(),
                TextEntry::make('effective_from')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('effective_until')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('slot_duration_minutes')
                    ->numeric(),
                TextEntry::make('buffer_time_minutes')
                    ->numeric(),
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
                    ->visible(fn (TrainerAvailability $record): bool => $record->trashed()),
            ]);
    }
}
