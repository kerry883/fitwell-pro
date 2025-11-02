<?php

namespace App\Filament\Admin\Resources\AutomatedMessages\Schemas;

use App\Models\AutomatedMessage;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AutomatedMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('template_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('trigger_condition')
                    ->badge(),
                TextEntry::make('scheduled_for')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
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
                    ->visible(fn (AutomatedMessage $record): bool => $record->trashed()),
            ]);
    }
}
