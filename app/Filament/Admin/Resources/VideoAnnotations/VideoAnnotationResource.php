<?php

namespace App\Filament\Admin\Resources\VideoAnnotations;

use App\Filament\Admin\Resources\VideoAnnotations\Pages\CreateVideoAnnotation;
use App\Filament\Admin\Resources\VideoAnnotations\Pages\EditVideoAnnotation;
use App\Filament\Admin\Resources\VideoAnnotations\Pages\ListVideoAnnotations;
use App\Filament\Admin\Resources\VideoAnnotations\Pages\ViewVideoAnnotation;
use App\Filament\Admin\Resources\VideoAnnotations\Schemas\VideoAnnotationForm;
use App\Filament\Admin\Resources\VideoAnnotations\Schemas\VideoAnnotationInfolist;
use App\Filament\Admin\Resources\VideoAnnotations\Tables\VideoAnnotationsTable;
use App\Models\VideoAnnotation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoAnnotationResource extends Resource
{
    protected static ?string $model = VideoAnnotation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Video Annotations';

    public static function form(Schema $schema): Schema
    {
        return VideoAnnotationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VideoAnnotationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoAnnotationsTable::configure($table);
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
            'index' => ListVideoAnnotations::route('/'),
            'create' => CreateVideoAnnotation::route('/create'),
            'view' => ViewVideoAnnotation::route('/{record}'),
            'edit' => EditVideoAnnotation::route('/{record}/edit'),
        ];
    }
}
