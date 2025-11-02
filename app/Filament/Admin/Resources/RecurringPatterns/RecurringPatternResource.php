<?php

namespace App\Filament\Admin\Resources\RecurringPatterns;

use App\Filament\Admin\Resources\RecurringPatterns\Pages\CreateRecurringPattern;
use App\Filament\Admin\Resources\RecurringPatterns\Pages\EditRecurringPattern;
use App\Filament\Admin\Resources\RecurringPatterns\Pages\ListRecurringPatterns;
use App\Filament\Admin\Resources\RecurringPatterns\Pages\ViewRecurringPattern;
use App\Filament\Admin\Resources\RecurringPatterns\Schemas\RecurringPatternForm;
use App\Filament\Admin\Resources\RecurringPatterns\Schemas\RecurringPatternInfolist;
use App\Filament\Admin\Resources\RecurringPatterns\Tables\RecurringPatternsTable;
use App\Models\RecurringPattern;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RecurringPatternResource extends Resource
{
    protected static ?string $model = RecurringPattern::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Recurring Pattern';

    public static function form(Schema $schema): Schema
    {
        return RecurringPatternForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RecurringPatternInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecurringPatternsTable::configure($table);
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
            'index' => ListRecurringPatterns::route('/'),
            'create' => CreateRecurringPattern::route('/create'),
            'view' => ViewRecurringPattern::route('/{record}'),
            'edit' => EditRecurringPattern::route('/{record}/edit'),
        ];
    }
}
