<?php
declare(strict_types=1);

return [
    // 日志组件
    'log_channel' => env('LOG_CHANNEL', 'default'),
    //
    'sql_debug' => env('SQL_DEBUG', false),

    // 是否记录用户日志
    'user_chat_log' => (bool) env('USER_LOG', false),

    'admin' => [
        'username' => env('ADMIN_USERNAME', 'admin'),
        'password' =>  env('ADMIN_PASSWORD', 'admin888'),
        'secret' => md5(env('ADMIN_USERNAME', 'admin') . env('ADMIN_PASSWORD', 'admin888')),
        'ttl' => env('ADMIN_TTL', 86400),
    ],

	// 七牛云
	'qiniu'=>[
		'access_key' => env('QINIU_ACCESS_KEY', ''), // 七牛云access_key
		'secret_key' => env('QINIU_SECRET_KEY', ''), // 七牛云secret_key
		'bucket' => env('QINIU_BUCKET', ''), // 七牛云bucket
		'domain' => env('QINIU_DOMAIN', ''), // 七牛云domain
		'path' => base64_decode(env('QINIU_PATH', '')), // 七牛云上传路径
		'expires' => env('QINIU_EXPIRES', 600), // 七牛云上传token过期时间
	],
];
