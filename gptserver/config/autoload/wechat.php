<?php

return [
    // 公众号
    'official' => [
        'app_id' => env('WECHAT_OFFICIAL_APPID'),
        'secret' => env('WECHAT_OFFICIAL_SECRET'),
    ],
    // 支付
    'pay' => [
        // 必要配置
        'app_id'             => env('WECHAT_OFFICIAL_APPID'),
        'mch_id'             => env('WECHAT_PAY_MCH_ID'),
        'key'                => env('WECHAT_PAY_V2_SECRET_KEY'),   // API v2 密钥 (注意: 是v2密钥 是v2密钥 是v2密钥)

        // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
        'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
        'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！

        'notify_url' => env('WECHAT_PAY_NOTIFY_URL'),

        /*
         * 接口请求相关配置，超时时间等，具体可用参数请参考：
         * https://github.com/symfony/symfony/blob/5.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
         */
        'http' => [
            'throw' => true, // 状态码非 200、300 时是否抛出异常，默认为开启
            'timeout' => 5.0,
            // 'base_uri' => 'https://api.mch.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri
        ],
    ],
];
