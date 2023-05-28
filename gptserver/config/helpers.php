<?php
declare(strict_types=1);

if (! function_exists('logger_config')) {
    /**
     * logger配置
     *
     * @param $name
     * @return array[]
     */
    function logger_config($name)
    {
        return [
            'handler' => [
                'class' => Monolog\Handler\StreamHandler::class,
                'constructor' => [
                    'stream' => BASE_PATH . sprintf('/runtime/logs/%s.log', $name),
                    'level' => Monolog\Logger::DEBUG,
                ],
            ],
            'formatter' => [
                'class' => Monolog\Formatter\LineFormatter::class,
                'constructor' => [
                    'format' => null,
                    'dateFormat' => 'Y-m-d H:i:s',
                    'allowInlineLineBreaks' => true,
                ],
            ],
        ];
    }
}


if (! function_exists('url')) {
    /**
     * url
     *
     * @param string $path
     * @return string
     */
    function url(string $path = '')
    {
        return rtrim(config('app_url'), '/') . '/' . ltrim($path, '/');
    }
}








