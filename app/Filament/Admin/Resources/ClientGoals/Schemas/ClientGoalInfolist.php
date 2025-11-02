<?php

namespace App\Filament\Admin\Resources\ClientGoals\Schemas;

use App\Models\ClientGoal;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClientGoalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('goal_title'),
                TextEntry::make('goal_description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('goal_type')
                    ->badge(),
                TextEntry::make('target_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('target_unit')
                    ->placeholder('-'),
                TextEntry::make('target_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('current_progress')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (ClientGoal $record): bool => $record->trashed()),
            ]);
    }
}
