<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OTP Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the OTP verification system.
    |
    */

    // OTP length
    'length' => (int)env('OTP_LENGTH', 6),

    // OTP expiry time in minutes
    'expiry' => (int)env('OTP_EXPIRY_MINUTES', 10),

    // Maximum verification attempts
    'max_attempts' => (int)env('OTP_MAX_ATTEMPTS', 3),

    // Cooldown period for resending OTP in seconds
    'resend_cooldown' => (int)env('OTP_COOLDOWN_SECONDS', 30),

    // Whether to log OTP codes (only in development)
    'log_codes' => env('APP_ENV') === 'local',

    // Development email configuration
    'dev_email' => [
        // Whether to show preview link in logs
        'show_preview' => env('APP_ENV') === 'local',
        
        // Whether to queue emails in development
        'use_queue' => env('QUEUE_CONNECTION') !== 'sync',
        
        // Mailtrap inbox URL for easy access
        'mailtrap_inbox' => env('MAILTRAP_INBOX_URL'),
    ],

    // Cleanup configuration
    'cleanup' => [
        // Whether to automatically clean up expired OTPs
        'enabled' => true,
        
        // How old (in hours) should OTPs be before cleanup
        'older_than_hours' => 24,
    ],
];