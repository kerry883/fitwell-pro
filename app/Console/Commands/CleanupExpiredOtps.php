<?php

namespace App\Console\Commands;

use App\Models\UserVerification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupExpiredOtps extends Command
{
    protected $signature = 'otp:cleanup';
    protected $description = 'Clean up expired OTP verification codes';

    public function handle()
    {
        try {
            $expiredCount = UserVerification::where('expires_at', '<', now())
                ->whereNull('verified_at')
                ->delete();

            Log::info('Cleaned up expired OTP codes', [
                'count' => $expiredCount,
                'date' => now()->toDateTimeString()
            ]);

            $this->info("Successfully deleted {$expiredCount} expired OTP codes.");
        } catch (\Exception $e) {
            Log::error('Failed to cleanup OTP codes', [
                'error' => $e->getMessage()
            ]);

            $this->error('Failed to cleanup OTP codes: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}