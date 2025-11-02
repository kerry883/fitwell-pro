<?php

namespace App\Filament\Admin\Resources\Videos;

use App\Filament\Admin\Resources\Videos\Pages\CreateVideo;
use App\Filament\Admin\Resources\Videos\Pages\EditVideo;
use App\Filament\Admin\Resources\Videos\Pages\ListVideos;
use App\Filament\Admin\Resources\Videos\Pages\ViewVideo;
use App\Filament\Admin\Resources\Videos\Schemas\VideoForm;
use App\Filament\Admin\Resources\Videos\Schemas\VideoInfolist;
use App\Filament\Admin\Resources\Videos\Tables\VideosTable;
use App\Models\Video;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Video';

    public static function form(Schema $schema): Schema
    {
        return VideoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VideoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideosTable::configure($table);
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
            'index' => ListVideos::route('/'),
            'create' => CreateVideo::route('/create'),
            'view' => ViewVideo::route('/{record}'),
            'edit' => EditVideo::route('/{record}/edit'),
        ];
    }
}
