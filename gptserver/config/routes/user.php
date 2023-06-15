<?php

use App\Http\Control as Api;
use Hyperf\HttpServer\Router\Router;

Router::addGroup('', function () {
    // openai接口
    Router::post('/openai/chat-process', [Api\Web\ChatController::class, 'process']);

    Router::addGroup('/user', function () {
        Router::get('/bill-package', [Api\Web\UserController::class, 'billPackage']);
        Router::get('/package', [Api\Web\UserController::class, 'package']);
        Router::get('/order', [Api\Web\UserController::class, 'order']);
        Router::get('/package/record', [Api\Web\UserController::class, 'packageRecord']);
        Router::get('/profile', [Api\Web\UserController::class, 'profile']);
    });

    Router::addGroup('/order', function () {
        Router::post('', [Api\Web\OrderController::class, 'create']);
        Router::get('/{id}/pay', [Api\Web\OrderController::class, 'pay']);
        Router::get('/{id}', [Api\Web\OrderController::class, 'show']);
    });

    Router::get('/package', [Api\Web\PackageController::class, 'index']);
    Router::post('/cdk', [Api\Web\CdkController::class, 'exchange']);
    Router::addGroup('/task', function () {
        Router::get('', [Api\Web\TaskController::class, 'index']);
        Router::post('/completion', [Api\Web\TaskController::class, 'completion']);
        Router::post('/check', [Api\Web\TaskController::class, 'checkTask']);
        Router::get('/record/unread', [Api\Web\TaskController::class, 'getRecordUnread']);
        Router::put('/record/{type}/read', [Api\Web\TaskController::class, 'updateRecordRead']);
    });
}, [
    'middleware' => [
        \App\Base\Auth\UserAuthMiddleware::class,
        \App\Middleware\MemberStatusMiddleware::class,
    ],
]);

// 模型
Router::get('/chat-gpt-model', [Api\Web\ChatGptModelController::class, 'index']);
Router::get('/docs/{project}/swagger', [Api\Common\DocsController::class, 'swagger']);
Router::get('/images/{fileName}', [Api\Common\ImageController::class, 'show']);

// 微信相关
Router::addGroup('/wechat', function () {
    Router::get('/jssdk', [Api\Web\WechatController::class, 'jssdk']);
    Router::get('/{platform}/qrcode', [Api\Web\WechatController::class, 'qrcode']);
    Router::get('/{platform}/redirect', [Api\Web\WechatController::class, 'redirect']);
    Router::post('/{platform}/user', [Api\Web\WechatController::class, 'code2User']);
    Router::post('/{platform}/login', [Api\Web\WechatController::class, 'login']);
});

// 用户名密码登录
Router::addGroup('/auth', function () {
    Router::post('/register', [Api\Web\AuthController::class, 'register']);
    Router::post('/login', [Api\Web\AuthController::class, 'login']);
    Router::post('/reset', [Api\Web\AuthController::class, 'reset']);
});

// 短信验证
Router::addGroup('/sms', function () {
    Router::post('/send-code', [Api\Web\SmsController::class, 'sendSmsCode']);
    Router::post('/login', [Api\Web\SmsController::class, 'login']);
});

Router::addGroup('/config', function () {
    Router::get('/basic-info', [Api\Web\ConfigController::class, 'getBasicInfo']);
    Router::get('/payment', [Api\Web\ConfigController::class, 'getPayment']);
    Router::get('/agreement', [Api\Web\ConfigController::class, 'getProtocol']);
    Router::get('/share', [Api\Web\ConfigController::class, 'getShare']);
});

// 通知路由
Router::post('/hook/{orderNo}/paid', [Api\Hook\WechatPayController::class, 'hook']);
