<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ClearSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all sessions and cache to fix login issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear sessions table
        DB::table('sessions')->truncate();
        $this->info('Sessions cleared successfully!');
        
        // Clear cache
        Cache::flush();
        $this->info('Cache cleared successfully!');
        
        $this->info('Login issues should now be resolved.');
    }
}
