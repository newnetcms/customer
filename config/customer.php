<?php

use Newnet\Customer\CustomerRedirectManager;
use Newnet\Customer\Models\Customer;

return [
    /*
    |--------------------------------------------------------------------------
    | Customer Config
    |--------------------------------------------------------------------------
    */
    'auth' => [
        'guards' => [
            'customer' => [
                'driver'   => 'session',
                'provider' => 'customers',
            ],
        ],

        'providers' => [
            'customers' => [
                'driver' => 'eloquent',
                'model'  => Customer::class,
            ],
        ],

        'passwords' => [
            'customers' => [
                'provider' => 'customers',
                'table'    => 'customer__password_resets',
                'expire'   => 60,
                'throttle' => 60,
            ],
        ],
    ],

    'enable_register' => true,

    'default_avatar' => null,

    'redirect_after_login' => [CustomerRedirectManager::class, 'afterLogin'],
    'redirect_after_register' => [CustomerRedirectManager::class, 'afterRegister'],
    'redirect_after_logout' => [CustomerRedirectManager::class, 'afterLogout'],
    'redirect_if_authenticated' => [CustomerRedirectManager::class, 'ifAuthenticated'],
    'redirect_if_unauthenticated' => [CustomerRedirectManager::class, 'ifUnauthenticated'],

    'login_username' => 'email_phone', // email|phone|email_phone

    'validator' => [
        'name' => true,
        'email' => true,
        'phone' => false,
        'password' => true,
        'password_confirmed' => env('CUSTOMER_VALIDATOR_PASSWORD_CONFIRMED', false),
    ],

    'api' => [
        'revoke_old_token' => env('CUSTOMER_API_REVOKE_OLD_TOKEN', true),
    ],
];
