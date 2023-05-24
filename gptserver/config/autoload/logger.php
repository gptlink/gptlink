<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
if (env('LOG_CHANNEL') == 'aliyun') {
    $aliyun = [
        'handler' => [
            'class' => Cblink\Monolog\Handler\AliyunLogHandler::class,
            'constructor' => [
                'access_id' => env('ALIYUN_LOG_ACCESS_ID'),
                'access_key' => env('ALIYUN_LOG_ACCESS_SECRET'),
                'endpoint' => env('ALIYUN_LOG_ENDPOINT'),
                'projectName' => env('ALIYUN_LOG_PROJECT_NAME'),
                'logName' => env('ALIYUN_LOG_NAME'),
            ],
        ],
    ];

    $exception = $aliyun;
    $exception['handler']['constructor']['logName'] = env('ALIYUN_LOG_EXCEPTION_NAME', env('ALIYUN_LOG_NAME'));

    return [
        'default' => $aliyun,
        'exception' => $exception,
        'sql' => $aliyun,
    ];
}


return [
    'default' => logger_config('hyperf'),
    'sql' => logger_config('log'),
    'exception' => logger_config('exception'),
];
