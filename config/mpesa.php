<?php

return [

    /*
    |--------------------------------------------------------------------------
    | M-PESA / Daraja API Credentials
    |--------------------------------------------------------------------------
    |
    | These values are pulled from your .env file.
    |
    */

    'consumer_key'    => env('MPESA_CONSUMER_KEY'),
    'consumer_secret' => env('MPESA_CONSUMER_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Shortcode & Passkey
    |--------------------------------------------------------------------------
    |
    | In sandbox use 174379; in production you’ll have your own pay-bill or till.
    |
    */

    'shortcode'       => env('MPESA_SHORTCODE'),
    'passkey'         => env('MPESA_PASSKEY'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | Set to 'sandbox' or 'production' in your .env.
    |
    */

    'env'             => env('MPESA_ENV'),

    /*
    |--------------------------------------------------------------------------
    | Callback URL
    |--------------------------------------------------------------------------
    |
    | This is where Daraja will send payment notifications.
    |
    */

    'callback_url'    => env('MPESA_CALLBACK_URL'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | These are the URLs for the Daraja API endpoints.
    | Use environment variables for flexibility.
    |
    */

    'oauth_endpoint'        => env('MPESA_OAUTH_ENDPOINT'),
    'stk_push_endpoint'     => env('MPESA_STK_PUSH_ENDPOINT'),
    'c2b_register_endpoint' => env('MPESA_C2B_REGISTER_ENDPOINT')
];    