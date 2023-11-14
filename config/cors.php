<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        '/',
        'api/*', 
        'sanctum/csrf-cookie',
        '/login',
        'signup',
        '/home',
        '/api/email/verification-notification',
        '/post/item',
        '/browse',
        '/view/item',
        '/location/list',
        '/inbox/inquire',
        '/inbox/list',
        '/inbox/update/is-read',
        '/inbox/messages',
        '/inbox/send-message',
        '/broadcasting/auth',
        '/checkout',
        '/checkout/list',
        '/checkout/cancel',
        '/checkout/delete',
        '/checkout/completed',
        '/transaction/create',
        '/transaction/list',
        '/transaction/proceed',
        '/transaction/cancel',
        '/transaction/additional',
        '/transaction/rate',
        '/wishlist/add',
        '/checkout/all-list',
        '/transaction/all-list',
        '/checkout/getCreditsByID',
        '/transaction/getTransactionsByID',
        '/verification-request',
        '/verification/all-list',
        '/verification/getVerificationListByID',
        '/verification/updateVerificationStatus',
        '/admin/top-users',
        '/admin/totals',
        '/report-user',
        '/reported-user/all-list',
        '/reported-user/getReportedUserByID',
        '/user/list',
        '/user/update',
        '/user/delete/*',
        '/mystore/getPostImagesByID',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
