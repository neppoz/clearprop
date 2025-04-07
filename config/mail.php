<?php

return [
    'default' => env('MAIL_MAILER', 'smtp'),
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'localhost'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', null),
            'username' => env('MAIL_USERNAME', null),
            'password' => env('MAIL_PASSWORD', null),
            'timeout' => null,
            'auth_mode' => null,
            'stream' => [
                'ssl' => [
                    'allow_self_signed' => env('MAIL_STREAM_ALLOW_SELF_SIGNED', false),
                    'verify_peer' => env('MAIL_STREAM_VERIFY_PEER', true),
                    'verify_peer_name' => env('MAIL_STREAM_VERIFY_PEER_NAME', true),
                ],
            ],
        ],
    ],
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-reply@clearprop.aero'),
        'name' => env('MAIL_FROM_NAME', 'ClearProp'),
    ],
];
