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
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    // 应用名称
    'app_name' => env('APP_NAME', 'gptlink'),

    'app_url' => env('APP_URL', 'http://127.0.0.1'),

    // 环境变量，可用 local, dev, prod
    'app_env' => env('APP_ENV', 'dev'),

    // 扫描文件缓存，线上需要开启
    'scan_cacheable' => env('SCAN_CACHEABLE', false),

    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            // LogLevel::DEBUG,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ],
    ],
];
