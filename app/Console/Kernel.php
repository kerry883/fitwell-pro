<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PruneOldNotifications;
use App\Console\Commands\SendPaymentReminders;
use App\Console\Commands\CancelExpiredPayments;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PruneOldNotifications::class,
        SendPaymentReminders::class,
        CancelExpiredPayments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Prune old notifications daily
        $schedule->command('notifications:prune')->daily();
        
        // Send payment reminders every hour
        $schedule->command('payments:send-reminders')->hourly();
        
        // Cancel expired payment assignments every hour
        $schedule->command('payments:cancel-expired')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
