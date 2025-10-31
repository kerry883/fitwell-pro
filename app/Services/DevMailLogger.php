<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\UserVerification;

class DevMailLogger
{
    /**
     * Log email details for development environment
     */
    public static function logOtpEmail($user, $otpCode)
    {
        if (!config('otp.log_codes')) {
            return;
        }

        $mailtrapUrl = config('otp.dev_email.mailtrap_inbox');
        $previewLink = $mailtrapUrl ? "\nMailtrap Inbox: {$mailtrapUrl}" : '';

        Log::channel('daily')->info(
            "Development OTP Email Details",
            [
                'recipient' => $user->email,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(config('otp.expiry'))->format('Y-m-d H:i:s'),
                'preview_available' => !empty($mailtrapUrl),
            ]
        );

        // Write to a separate log file for easy access
        $logMessage = sprintf(
            "📧 OTP Email Details:\nTo: %s\nCode: %s\nExpires: %s%s",
            $user->email,
            $otpCode,
            now()->addMinutes(config('otp.expiry'))->format('Y-m-d H:i:s'),
            $previewLink
        );

        file_put_contents(
            storage_path('logs/otp-development.log'),
            '[' . now()->format('Y-m-d H:i:s') . '] ' . $logMessage . "\n\n",
            FILE_APPEND
        );
    }

    /**
     * Log email delivery status
     */
    public static function logDeliveryStatus($user, $status, $error = null)
    {
        if (!config('otp.log_codes')) {
            return;
        }

        Log::channel('daily')->info(
            "OTP Email Delivery Status",
            [
                'user_id' => $user->id,
                'email' => $user->email,
                'status' => $status,
                'error' => $error,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]
        );
    }
}