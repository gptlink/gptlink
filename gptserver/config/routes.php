<?php

declare(strict_types=1);

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

    // 七牛云
    Router::addGroup('/qiniu', function () {
        Router::get('/token', [Api\Common\QiniuController::class, 'getUploadToken']);
    });

    // 素材
    Router::get('/material', [Api\Web\MaterialController::class, 'index']);
}, [
    'middleware' => [
        \App\Base\Auth\UserAuthMiddleware::class,
        \App\Middleware\MemberStatusMiddleware::class,
    ],
]);

// 模型
Router::get('/chat-gpt-model', [Api\Web\ChatGptModelController::class, 'index']);
Router::get('/chat-gpt-model/{id}', [Api\Web\ChatGptModelController::class, 'show']);

// 微信相关
Router::addGroup('/wechat', function () {
    Router::get('/jssdk', [Api\Web\WechatController::class, 'jssdk']);
    Router::get('/{platform}/qrcode', [Api\Web\WechatController::class, 'qrcode']);
    Router::get('/{platform}/redirect', [Api\Web\WechatController::class, 'redirect']);
    Router::post('/{platform}/user', [Api\Web\WechatController::class, 'code2User']);
    Router::post('/{platform}/login', [Api\Web\WechatController::class, 'login']);
});

// 短信验证
Router::addGroup('/sms', function () {
    Router::post('/send-code', [Api\Web\SmsController::class, 'sendSmsCode']);
    Router::post('/login', [Api\Web\SmsController::class, 'login']);
});
// 基本页面配置
Router::get('/config/basic-info', [Api\Web\ConfigController::class, 'getBasicInfo']);

// 通知路由
Router::post('/hook/{orderNo}/paid', [Api\Hook\WechatPayController::class, 'hook']);

Router::post('/admin/login', [Api\Admin\AuthController::class, 'login']);

# 管理端路由
Router::addGroup('/admin', function () {
    // 用户
    Router::addGroup('/member', function () {
        Router::get('', [Api\Admin\MemberController::class, 'index']);
        Router::get('/{id}/package', [Api\Admin\MemberController::class, 'getPackage']);
        Router::post('/{id}/package', [Api\Admin\MemberController::class, 'givePackage']);
        Router::put('/{id}/status', [Api\Admin\MemberController::class, 'updateStatus']);
        Router::get('/package/record', [Api\Admin\MemberController::class, 'packageRecord']);
        Router::get('/wechat-oauth/record', [Api\Admin\MemberController::class, 'wechatOauthRecord']);
        Router::post('/wechat-oauth/unbind', [Api\Admin\MemberController::class, 'unbindWechatOauth']);
    });

    // 订单
    Router::addGroup('/order', function () {
        Router::get('', [Api\Admin\OrderController::class, 'index']);
    });

    // 套餐
    Router::addGroup('/package', function () {
        Router::get('', [Api\Admin\PackageController::class, 'index']);
        Router::get('/{id}', [Api\Admin\PackageController::class, 'show']);
        Router::post('', [Api\Admin\PackageController::class, 'store']);
        Router::put('/{id}', [Api\Admin\PackageController::class, 'update']);
        Router::put('/{id}/show', [Api\Admin\PackageController::class, 'updateShow']);
    });

    // 模型
    Router::addGroup('/chat-gpt-model', function () {
        Router::get('', [Api\Admin\ChatGptModelController::class, 'index']);
        Router::get('/{id}', [Api\Admin\ChatGptModelController::class, 'show']);
        Router::post('', [Api\Admin\ChatGptModelController::class, 'store']);
        Router::put('/{id}', [Api\Admin\ChatGptModelController::class, 'update']);
        Router::put('/{id}/status', [Api\Admin\ChatGptModelController::class, 'updateStatus']);
        Router::post('/{id}/top', [Api\Admin\ChatGptModelController::class, 'top']);
        Router::post('/{id}/cancel-top', [Api\Admin\ChatGptModelController::class, 'cancelTop']);
        Router::post('/{id}/copy-gpt', [Api\Admin\ChatGptModelController::class, 'copyModel']);
        Router::get('/{id}/violation', [Api\Admin\ChatGptModelController::class, 'getViolationRecord']);
    });

    // 任务
    Router::addGroup('/task', function () {
        Router::get('/record', [Api\Admin\TaskRecordController::class, 'index']);
        Router::get('', [Api\Admin\TaskController::class, 'index']);
        Router::get('/{type}', [Api\Admin\TaskController::class, 'show']);
        Router::post('/{type}', [Api\Admin\TaskController::class, 'store']);
        Router::put('/{type}/status', [Api\Admin\TaskController::class, 'updateStatus']);
    });

    // 配置项
    Router::addGroup('/config', function () {
        Router::get('/{type}', [Api\Admin\ConfigController::class, 'show']);
        Router::post('/{type}', [Api\Admin\ConfigController::class, 'store']);
    });

    // 七牛云
    Router::addGroup('/qiniu', function () {
        Router::get('/token', [Api\Common\QiniuController::class, 'getUploadToken']);
    });

    // 素材管理
    Router::addGroup('/material', function () {
        Router::get('', [Api\Admin\MaterialController::class, 'index']);
        Router::post('', [Api\Admin\MaterialController::class, 'store']);
        Router::delete('/{id}', [Api\Admin\MaterialController::class, 'destroy']);
    });

    // 开发者套餐
    Router::addGroup('/develop', function () {
        Router::get('/package', [Api\Admin\DevelopController::class, 'getPackage']);
    });

    // 统计
    Router::addGroup('/statistics', function () {
        Router::get('/count', [Api\Admin\StatisticsController::class, 'index']);
    });
}, [
    'middleware' => [
        \App\Base\Auth\AdminAuthMiddleware::class,
    ],
]);
