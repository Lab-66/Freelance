<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'secret' => env('STRIPE_KEY'),
        'key' => env('STRIPE_SECRET'),
    ],
    'github' => [
    'client_id' => '04c44400474c40de887d',
    'client_secret' => '55d86dde464e2433efba6ddc71eb66165347de1d',
    'redirect' => 'http://93.158.221.197/files/public/',
    ],
    'mollie' => [
    'client_id' => env('C11C82CA'),
    'client_secret' => env('4CA37E7321AE19D577AD2C8DC484202B80D51288'),
    'redirect' => env('http://93.158.221.197/files/public/'),
    ],

];
