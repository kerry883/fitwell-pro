<?php

namespace App\Filament\Admin\Resources\VideoFeedback;

use App\Filament\Admin\Resources\VideoFeedback\Pages\CreateVideoFeedback;
use App\Filament\Admin\Resources\VideoFeedback\Pages\EditVideoFeedback;
use App\Filament\Admin\Resources\VideoFeedback\Pages\ListVideoFeedback;
use App\Filament\Admin\Resources\VideoFeedback\Pages\ViewVideoFeedback;
use App\Filament\Admin\Resources\VideoFeedback\Schemas\VideoFeedbackForm;
use App\Filament\Admin\Resources\VideoFeedback\Schemas\VideoFeedbackInfolist;
use App\Filament\Admin\Resources\VideoFeedback\Tables\VideoFeedbackTable;
use App\Models\VideoFeedback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoFeedbackResource extends Resource
{
    protected static ?string $model = VideoFeedback::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Video Feedbacks';

    public static function form(Schema $schema): Schema
    {
        return VideoFeedbackForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VideoFeedbackInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoFeedbackTable::configure($table);
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
            'index' => ListVideoFeedback::route('/'),
            'create' => CreateVideoFeedback::route('/create'),
            'view' => ViewVideoFeedback::route('/{record}'),
            'edit' => EditVideoFeedback::route('/{record}/edit'),
        ];
    }
}
