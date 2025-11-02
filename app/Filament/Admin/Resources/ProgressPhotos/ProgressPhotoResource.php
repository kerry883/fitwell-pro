<?php

namespace App\Filament\Admin\Resources\ProgressPhotos;

use App\Filament\Admin\Resources\ProgressPhotos\Pages\CreateProgressPhoto;
use App\Filament\Admin\Resources\ProgressPhotos\Pages\EditProgressPhoto;
use App\Filament\Admin\Resources\ProgressPhotos\Pages\ListProgressPhotos;
use App\Filament\Admin\Resources\ProgressPhotos\Pages\ViewProgressPhoto;
use App\Filament\Admin\Resources\ProgressPhotos\Schemas\ProgressPhotoForm;
use App\Filament\Admin\Resources\ProgressPhotos\Schemas\ProgressPhotoInfolist;
use App\Filament\Admin\Resources\ProgressPhotos\Tables\ProgressPhotosTable;
use App\Models\ProgressPhoto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgressPhotoResource extends Resource
{
    protected static ?string $model = ProgressPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Progress Images';

    public static function form(Schema $schema): Schema
    {
        return ProgressPhotoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgressPhotoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgressPhotosTable::configure($table);
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
            'index' => ListProgressPhotos::route('/'),
            'create' => CreateProgressPhoto::route('/create'),
            'view' => ViewProgressPhoto::route('/{record}'),
            'edit' => EditProgressPhoto::route('/{record}/edit'),
        ];
    }
}
