<?php

declare(strict_types=1);
use Qbhy\SimpleJwt\Encoders;
use Qbhy\SimpleJwt\EncryptAdapters as Encrypter;

return [
    'default' => [
        'guard' => 'user',
        'provider' => 'users',
    ],
    'guards' => [
        'admin' => [
            'driver' => \App\Base\Auth\AdminGuard::class,
            'provider' => 'users',
        ],
        'user' => [
            'driver' => Qbhy\HyperfAuth\Guard\JwtGuard::class,
            'provider' => 'users',

            /*
             * 以下是 simple-jwt 配置
            * 必填
            * jwt 服务端身份标识
            */
            'secret' => env('JWT_SECRET', md5(env('APP_NAME', 'gptlink'))),

            /*
             * 可选配置
             * jwt 默认头部token使用的字段
             */
            'header_name' => env('JWT_HEADER_NAME', 'Authorization'),

            /*
             * 可选配置
             * jwt 生命周期，单位秒，默认一天
             */
            'ttl' => (int) env('SIMPLE_JWT_TTL', 86400 * 7),

            /*
             * 可选配置
             * 允许过期多久以内的 token 进行刷新，单位秒，默认一周
             */
            'refresh_ttl' => (int) env('SIMPLE_JWT_REFRESH_TTL', 86400 * 14),

            /*
             * 可选配置
             * 默认使用的加密类
             */
            'default' => Encrypter\SHA1Encrypter::class,

            /*
             * 可选配置
             * 加密类必须实现 Qbhy\SimpleJwt\Interfaces\Encrypter 接口
             */
            'drivers' => [
                Encrypter\PasswordHashEncrypter::alg() => Encrypter\PasswordHashEncrypter::class,
                Encrypter\CryptEncrypter::alg() => Encrypter\CryptEncrypter::class,
                Encrypter\SHA1Encrypter::alg() => Encrypter\SHA1Encrypter::class,
                Encrypter\Md5Encrypter::alg() => Encrypter\Md5Encrypter::class,
            ],

            /*
             * 可选配置
             * 编码类
             */
            'encoder' => new Encoders\Base64UrlSafeEncoder(),
            //            'encoder' => new Encoders\Base64Encoder(),

            /*
             * 可选配置
             * 缓存类
             */
            'cache' => function () {
                return make(\Qbhy\HyperfAuth\HyperfRedisCache::class);
            },

            /*
            * 可选配置
            * 缓存前缀
            */
            'prefix' => env('SIMPLE_JWT_PREFIX', 'default'),
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => \Qbhy\HyperfAuth\Provider\EloquentProvider::class,
            'model' => App\Model\Member::class,
        ],
    ],
];
