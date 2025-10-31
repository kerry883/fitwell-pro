<?php

return [
    /*
    |--------------------------------------------------------------------------
    | M-Pesa Daraja 3.0 Configuration
    |--------------------------------------------------------------------------
    */

    'environment' => env('MPESA_ENVIRONMENT', 'sandbox'),

    'app_key' => env('MPESA_APP_KEY'),
    'app_secret' => env('MPESA_APP_SECRET'),
    'initiator_name' => env('MPESA_INITIATOR_NAME'),
    'business_shortcode' => env('MPESA_BUSINESS_SHORTCODE'),
    'merchant_id' => env('MPESA_MERCHANT_ID'),
    'passkey' => env('MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'), // Sandbox default

    // Daraja 2.0 Sandbox URLs (v3 endpoints are not available yet)
    'sandbox_baseurl' => 'https://sandbox.safaricom.co.ke',
    'sandbox_token_url' => '/oauth/v1/generate?grant_type=client_credentials',
    'sandbox_stkpush_url' => '/mpesa/stkpush/v1/processrequest',
    'sandbox_stkstatus_url' => '/mpesa/stkpushquery/v1/query',

    // Daraja 2.0 Production URLs
    'live_baseurl' => 'https://api.safaricom.co.ke',
    'live_token_url' => '/oauth/v1/generate?grant_type=client_credentials',
    'live_stkpush_url' => '/mpesa/stkpush/v1/processrequest',
    'live_stkstatus_url' => '/mpesa/stkpushquery/v1/query',

    // CallBack URL
    'callback_url' => env('MPESA_CALLBACK_URL', env('APP_URL') . '/mpesa/callback'),

    // Currency conversion rate (1 USD to KES)
    'usd_to_kes_rate' => env('MPESA_USD_TO_KES_RATE', 150),
];