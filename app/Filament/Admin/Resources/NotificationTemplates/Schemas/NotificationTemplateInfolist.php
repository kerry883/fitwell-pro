<?php

namespace App\Filament\Admin\Resources\NotificationTemplates\Schemas;

use App\Models\NotificationTemplate;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NotificationTemplateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('template_name'),
                TextEntry::make('trigger_event')
                    ->badge(),
                TextEntry::make('subject'),
                TextEntry::make('email_template')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('sms_template')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('push_template')
                    ->placeholder('-')
                    ->columnSpanFull(),
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
                    ->visible(fn (NotificationTemplate $record): bool => $record->trashed()),
            ]);
    }
}
