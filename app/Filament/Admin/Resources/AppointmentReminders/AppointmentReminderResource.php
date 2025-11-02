<?php

namespace App\Filament\Admin\Resources\AppointmentReminders;

use App\Filament\Admin\Resources\AppointmentReminders\Pages\CreateAppointmentReminder;
use App\Filament\Admin\Resources\AppointmentReminders\Pages\EditAppointmentReminder;
use App\Filament\Admin\Resources\AppointmentReminders\Pages\ListAppointmentReminders;
use App\Filament\Admin\Resources\AppointmentReminders\Pages\ViewAppointmentReminder;
use App\Filament\Admin\Resources\AppointmentReminders\Schemas\AppointmentReminderForm;
use App\Filament\Admin\Resources\AppointmentReminders\Schemas\AppointmentReminderInfolist;
use App\Filament\Admin\Resources\AppointmentReminders\Tables\AppointmentRemindersTable;
use App\Models\AppointmentReminder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AppointmentReminderResource extends Resource
{
    protected static ?string $model = AppointmentReminder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Appointment Reminder';

    public static function form(Schema $schema): Schema
    {
        return AppointmentReminderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AppointmentReminderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentRemindersTable::configure($table);
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
            'index' => ListAppointmentReminders::route('/'),
            'create' => CreateAppointmentReminder::route('/create'),
            'view' => ViewAppointmentReminder::route('/{record}'),
            'edit' => EditAppointmentReminder::route('/{record}/edit'),
        ];
    }
}
