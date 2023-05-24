<?php

declare(strict_types=1);

return [
    'scan' => [
        'paths' => [
            BASE_PATH . '/app',
        ],
        'ignore_annotations' => [
            'mixin',
        ],
        'class_map' => [
            \Hyperf\HttpMessage\Server\Connection\SwooleConnection::class => BASE_PATH . '/app/Base/ClassMap/SwooleConnection.php',
        ],
    ],
];
