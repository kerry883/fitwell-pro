<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckSessions extends Command
{
    protected $signature = 'sessions:check';
    protected $description = 'Check current sessions in database';

    public function handle()
    {
        $this->info('Checking sessions table...');
        
        $sessionCount = DB::table('sessions')->count();
        $this->info("Total sessions: {$sessionCount}");
        
        if ($sessionCount > 0) {
            $sessions = DB::table('sessions')->get(['id', 'user_id', 'last_activity']);
            
            $this->info("\nActive sessions:");
            foreach ($sessions as $session) {
                $userId = $session->user_id ?? 'guest';
                $lastActivity = date('Y-m-d H:i:s', $session->last_activity);
                $this->line("ID: {$session->id}");
                $this->line("User: {$userId}");
                $this->line("Last Activity: {$lastActivity}");
                $this->line("---");
            }
        } else {
            $this->info("No sessions found in database.");
        }
        
        // Check for the specific session ID mentioned
        $specificId = '1vRGtbOeOEWeggkseKl4MyeBZ80mIuvaKBA60Qkk';
        $specificSession = DB::table('sessions')->where('id', $specificId)->first();
        
        if ($specificSession) {
            $this->error("Found the problematic session: {$specificId}");
            $this->line("User ID: " . ($specificSession->user_id ?? 'null'));
            $this->line("Last Activity: " . date('Y-m-d H:i:s', $specificSession->last_activity));
        } else {
            $this->info("The problematic session ID {$specificId} was not found in database.");
        }
        
        return 0;
    }
}