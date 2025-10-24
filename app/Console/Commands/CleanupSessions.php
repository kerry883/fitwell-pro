<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:cleanup {--force : Force cleanup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired sessions from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lifetime = config('session.lifetime', 120);
        $expiry = now()->subMinutes($lifetime)->timestamp;
        
        // Count expired sessions
        $expiredCount = DB::table('sessions')->where('last_activity', '<', $expiry)->count();
        
        if ($expiredCount === 0) {
            $this->info('No expired sessions found.');
            return;
        }
        
        $this->info("Found {$expiredCount} expired sessions.");
        
        if (!$this->option('force') && !$this->confirm('Do you want to delete these sessions?')) {
            $this->info('Cleanup cancelled.');
            return;
        }
        
        // Delete expired sessions
        $deleted = DB::table('sessions')->where('last_activity', '<', $expiry)->delete();
        
        $this->info("Successfully deleted {$deleted} expired sessions.");
        
        // Also clean up orphaned sessions (sessions without valid users)
        $orphanedCount = DB::table('sessions')
            ->whereNotNull('user_id')
            ->whereNotExists(function ($query) {
                $query->select('id')
                    ->from('users')
                    ->whereRaw('users.id = sessions.user_id');
            })
            ->count();
            
        if ($orphanedCount > 0) {
            $this->info("Found {$orphanedCount} orphaned sessions (invalid users).");
            
            if ($this->option('force') || $this->confirm('Delete orphaned sessions too?')) {
                $orphanedDeleted = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->whereNotExists(function ($query) {
                        $query->select('id')
                            ->from('users')
                            ->whereRaw('users.id = sessions.user_id');
                    })
                    ->delete();
                    
                $this->info("Deleted {$orphanedDeleted} orphaned sessions.");
            }
        }
    }
}
