<?php

namespace App\Filament\Admin\Resources\TrainerAvailabilities;

use App\Filament\Admin\Resources\TrainerAvailabilities\Pages\CreateTrainerAvailability;
use App\Filament\Admin\Resources\TrainerAvailabilities\Pages\EditTrainerAvailability;
use App\Filament\Admin\Resources\TrainerAvailabilities\Pages\ListTrainerAvailabilities;
use App\Filament\Admin\Resources\TrainerAvailabilities\Pages\ViewTrainerAvailability;
use App\Filament\Admin\Resources\TrainerAvailabilities\Schemas\TrainerAvailabilityForm;
use App\Filament\Admin\Resources\TrainerAvailabilities\Schemas\TrainerAvailabilityInfolist;
use App\Filament\Admin\Resources\TrainerAvailabilities\Tables\TrainerAvailabilitiesTable;
use App\Models\TrainerAvailability;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainerAvailabilityResource extends Resource
{
    protected static ?string $model = TrainerAvailability::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Available Trainners';

    public static function form(Schema $schema): Schema
    {
        return TrainerAvailabilityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainerAvailabilityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainerAvailabilitiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainerAvailabilities::route('/'),
            'create' => CreateTrainerAvailability::route('/create'),
            'view' => ViewTrainerAvailability::route('/{record}'),
            'edit' => EditTrainerAvailability::route('/{record}/edit'),
        ];
    }
}
