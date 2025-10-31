<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This is the default currency for the application.
    | All prices are stored in this currency in the database.
    |
    */

    'default' => env('DEFAULT_CURRENCY', 'KES'),

    /*
    |--------------------------------------------------------------------------
    | Supported Currencies
    |--------------------------------------------------------------------------
    |
    | List of currencies supported by the application with their details.
    |
    */

    'currencies' => [
        'KES' => [
            'name' => 'Kenyan Shilling',
            'symbol' => 'KSh',
            'code' => 'KES',
            'decimals' => 2,
            'format' => 'KSh %s',
        ],
        'USD' => [
            'name' => 'US Dollar',
            'symbol' => '$',
            'code' => 'USD',
            'decimals' => 2,
            'format' => '$%s',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Exchange Rates
    |--------------------------------------------------------------------------
    |
    | Exchange rates relative to the default currency (KES).
    | These rates represent how much 1 KES equals in each currency.
    |
    */

    'exchange_rates' => [
        'KES' => 1.0,
        'USD' => 1 / 129.20, // 1 KES = 0.00774 USD (or 1 USD = 129.20 KES)
    ],

    /*
    |--------------------------------------------------------------------------
    | Conversion Rate (for backwards compatibility)
    |--------------------------------------------------------------------------
    */

    'kes_to_usd_rate' => 129.20,
    'usd_to_kes_rate' => 129.20,

    /*
    |--------------------------------------------------------------------------
    | Minimum Amounts
    |--------------------------------------------------------------------------
    |
    | Minimum amounts for different payment processors in their respective currencies.
    |
    */

    'minimum_amounts' => [
        'stripe' => [
            'amount' => 0.50,
            'currency' => 'USD',
        ],
        'mpesa' => [
            'amount' => 1.00,
            'currency' => 'KES',
        ],
    ],
];
