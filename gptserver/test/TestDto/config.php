<?php


return [
// yap请求地址
    'base_url' => 'http://yapi.cblink.net/',
    // 文档合并方式，"normal"(普通模式) , "good"(智能合并), "merge"(完全覆盖)
    'merge' => 'merge',

    'base_path' => BASE_PATH . '/runtime/yapi/',

    'config' => [
        'default' => [
            'id' => '815',
            'token' => '7f5e7d6ab11a25c6f3c81a8d7782ce5b69fe0c4de68125d2ce9dbc7e7a57a192'
        ],
        'admin' => [
            'id' => '808',
            'token' => 'c4edb3870a73acfc98e53374fe5acff9a36a996bccae60467b606f6dc1a63243'
        ]
    ],

    'public' => [
        'prefix' => 'data',

        // 公共的请求参数,query部分
        'query' => [
            'page' => ['plan' => '页码，默认1'],
            'per_page' => ['plan' => '每页数量，不超过200，默认15'],
            'is_all' => ['plan' => '是否获取全部数据，不超过1000条'],
        ],

        'headers' => [
            'Authorization' => ['plan' => '认证信息', 'must' => true, 'required' => true],
        ],

        // 公共的响应参数
        'data' => [
            'err_code' => ['plan' => '错误码，0表示成功', 'must' => true, 'required' => true],
            'err_msg' => ['plan' => '错误说明，请求失败时返回', 'must' => true],
            'meta' => [
                'plan' => '分页数据',
                'must' => false,
                'children' => [
                    'current_page' => ['plan' => '当前页数'],
                    'total' => ['plan' => '总数量'],
                    'per_page' => ['plan' => '每页数量'],
                ],
            ],
        ],
    ],
];
