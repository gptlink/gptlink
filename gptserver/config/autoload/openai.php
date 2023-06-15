<?php

use App\Base\Consts\ModelConst;

return [
    'user_white_list' => env('USER_WHITE_LIST', ''),

    'base_url' => env('OPENAI_BASE_URL', 'https://api.gpt-link.com/'),

    'chat' => [
        'host' => env('OPENAI_HOST'),
        'port' => (int) env('OPENAI_PORT'),
        'model' => env('OPENAI_MODEL', ModelConst::GPT_35_TURBO),
        'max_tokens' => (int) env('OPENAI_MAX_TOKENS', 4000),
        'max_response_tokens' => (int) env('OPENAI_MAX_RESPONSE_TOKENS', 1000),

        'proxy' => [
            'socks5_host' => env('OPENAI_PROXY_HOST'),
            'socks5_port' => (int) env('OPENAI_PROXY_PORT'),
        ]
    ],
];
