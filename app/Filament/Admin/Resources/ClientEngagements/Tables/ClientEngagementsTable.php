<?php

namespace App\Filament\Admin\Resources\ClientEngagements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientEngagementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tracking_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('workouts_completed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('videos_uploaded')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('messages_sent')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('logins_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('completion_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_activity')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
