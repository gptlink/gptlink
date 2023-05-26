<?php

return [
    'user_white_list' => env('USER_WHITE_LIST', ''),

    'base_url' => env('OPENAI_BASE_URL', 'https://api.gpt-link.com/'),


    'chat' => [
        'host' => env('OPENAI_HOST', 'api.gpt-link.com'),
        'port' => env('OPENAI_PORT', 443),

        'proxy' => [
            'socks5_host' => env('OPENAI_PROXY_HOST'),
            'socks5_port' => env('OPENAI_PROXY_PORT'),
        ]
    ],
];
