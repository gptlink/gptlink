<?php


$providers = [
    \HyperfSocialiteProviders\Weixin\Provider::class,
    \HyperfSocialiteProviders\WeixinWeb\Provider::class,
];

// 使用跳板
if (env('WECHAT_JUMP', false)) {
    $providers = [
        // \HyperfSocialiteProviders\Weixin\Provider::class,
        \App\Base\WechatServiceProvider::class,
        \App\Base\WechatWebServiceProvider::class,
    ];
}

return [
    // auto load providers
    'providers' => $providers,
    'config' => [
        'weixin' => [
            'client_id' => env('WECHAT_OFFICIAL_APPID'),
            'client_secret' => env('WECHAT_OFFICIAL_SECRET'),
        ],
        // 微信
        'weixinweb' => [
            'client_id' => env('WEIXINWEB_CLIENT_ID'),
            'client_secret' => env('WEIXINWEB_CLIENT_SECRET'),
            'redirect' => env('WEIXINWEB_REDIRECT_URI')
        ],
        /*
        // 企业微信扫码，第三方应用
        'wework_third_qr' => [
            // corp id
            'client_id' => env('WEWORK_CLIENT_ID'),
            // provider secret
            'client_secret' => env('WEWORK_CLIENT_SECRET'),
            'redirect' => env('WEWORK_REDIRECT_URI')
        ],
        // 企业微信
        'wework' => [
            // corp id
            'client_id' => env('WEWORK_CLIENT_ID'),
            // corp secret
            'client_secret' => env('WEWORK_CLIENT_SECRET'),
            'redirect' => env('WEWORK_REDIRECT_URI')
        ],
        // 企业微信扫码
        'wework_qr' => [
            // corp id
            'client_id' => env('WEWORK_CLIENT_ID'),
            // corp secret
            'client_secret' => env('WEWORK_CLIENT_SECRET'),
            'agentid' => env('WEWORKQR_AGENT_ID'),
            'redirect' => env('WEWORKQR_REDIRECT_URI')
        ],
        */
    ],
];
