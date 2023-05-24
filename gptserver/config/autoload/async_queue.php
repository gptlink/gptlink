<?php

declare(strict_types=1);

return [
    'default' => [
        'driver' => Hyperf\AsyncQueue\Driver\RedisDriver::class,
        'redis' => [
            'pool' => 'default',
        ],
        'channel' => '{queue}',
        'timeout' => 2,
        // 重新尝试的间隔时间
        'retry_seconds' => [5, 10, 60],
        // 消息处理超时的时间
        'handle_timeout' => 60,
        // 消费的进程数量
        'processes' => (int) env('ASYNC_QUEUE_PROCESSES', 1),
        // 同时处理消费的数量
        'concurrent' => [
            'limit' => 10,
        ],
        // 进程处理多少消费后重启
        'max_messages' => 3000
    ],
];
