<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class PruneOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune old notifications (older than 90 days)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Pruning old notifications...');

        try {
            $cutoffDate = now()->subDays(90);
            $deletedCount = Notification::where('created_at', '<', $cutoffDate)->delete();

            $this->info("Successfully deleted {$deletedCount} notifications older than 90 days.");
            Log::info("PruneOldNotifications: Successfully deleted {$deletedCount} notifications.");

        } catch (\Exception $e) {
            $this->error('An error occurred while pruning notifications.');
            Log::error('PruneOldNotifications: Failed to prune old notifications. Error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
