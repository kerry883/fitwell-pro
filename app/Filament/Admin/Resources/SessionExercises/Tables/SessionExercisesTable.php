<?php

namespace App\Filament\Admin\Resources\SessionExercises\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessionExercisesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('exercise_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('exercise_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sets')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reps')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight_unit')
                    ->searchable(),
                TextColumn::make('duration_seconds')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('distance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('distance_unit')
                    ->searchable(),
                TextColumn::make('rest_seconds')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_superset')
                    ->boolean(),
                TextColumn::make('superset_group')
                    ->numeric()
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
