<?php

use App\Http\Control as Api;
use Hyperf\HttpServer\Router\Router;

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
        Router::delete('/{id}', [Api\Admin\PackageController::class, 'destroy']);
    });

    // 模型
    Router::addGroup('/chat-gpt-model', function () {
        Router::get('', [Api\Admin\ChatGptModelController::class, 'index']);
        Router::get('/{id}', [Api\Admin\ChatGptModelController::class, 'show']);
        Router::post('', [Api\Admin\ChatGptModelController::class, 'store']);
        Router::put('/{id}', [Api\Admin\ChatGptModelController::class, 'update']);
        Router::delete('/{id}', [Api\Admin\ChatGptModelController::class, 'destroy']);
        Router::put('/{id}/status', [Api\Admin\ChatGptModelController::class, 'updateStatus']);
        Router::post('/{id}/top', [Api\Admin\ChatGptModelController::class, 'top']);
        Router::post('/{id}/cancel-top', [Api\Admin\ChatGptModelController::class, 'cancelTop']);
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

    // CDK管理
    Router::addGroup('/cdk', function () {
        Router::get('', [Api\Admin\CdkController::class, 'index']);
        Router::get('/group', [Api\Admin\CdkController::class, 'group']);
        Router::get('/export', [Api\Admin\CdkController::class, 'export']);
        Router::get('/{id}', [Api\Admin\CdkController::class, 'show']);
        Router::post('', [Api\Admin\CdkController::class, 'store']);
        Router::put('/{id}', [Api\Admin\CdkController::class, 'update']);
    });

    // 分销相关
    Router::addGroup('/salesman', function () {
        // 提现记录
        Router::addGroup('/withdraw', function () {
            Router::get('', [Api\Admin\WithdrawController::class, 'index']);
            Router::post('/{id}/agree', [Api\Admin\WithdrawController::class, 'agree']);
            Router::post('/{id}/refuse', [Api\Admin\WithdrawController::class, 'refuse']);
            Router::post('/{id}/transfer', [Api\Admin\WithdrawController::class, 'transfer']);
        });

        // 提现记录
        Router::get('/order', [Api\Admin\SalesmanController::class, 'order']);
        // 分销员
        Router::get('/user', [Api\Admin\SalesmanController::class, 'index']);
        Router::get('/user/{id}', [Api\Admin\SalesmanController::class, 'show']);
    });

    Router::addGroup('/upload', function () {
        Router::get('/qiniu/token', [Api\Common\UploadController::class, 'getQiniuToken']);
        Router::post('/image', [Api\Common\UploadController::class, 'uploadImage']);
    });

    // 开发者套餐
    Router::addGroup('/develop', function () {
        // 开发者个人信息
        Router::get('/profile', [Api\Admin\DevelopController::class, 'getProfile']);
        Router::get('/package', [Api\Admin\DevelopController::class, 'getPackage']);
        Router::get('/record', [Api\Admin\DevelopController::class, 'getRcord']);
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
