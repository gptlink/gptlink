<?php

use App\Http\Control as Api;
use Hyperf\HttpServer\Router\Router;


// 分销接口
Router::addGroup('/salesman', function () {

    Router::get('/order', [Api\Salesman\OrderController::class, 'index']);
    Router::get('/child', [Api\Salesman\ChildController::class, 'index']);

    Router::get('/statistics', [Api\Salesman\SalesmanController::class, 'statistics']);
    Router::get('/balance', [Api\Salesman\SalesmanController::class, 'balance']);
    Router::get('/withdrawal', [Api\Salesman\WithdrawalController::class, 'index']);
    Router::get('/withdrawal/last', [Api\Salesman\WithdrawalController::class, 'lastAccount']);
    Router::post('/withdrawal/apply', [Api\Salesman\WithdrawalController::class, 'apply']);
}, [
    'middleware' => [
        \App\Base\Auth\UserAuthMiddleware::class,
        \App\Middleware\MemberStatusMiddleware::class,
        \App\Middleware\SalesmanMiddleware::class,
    ],
]);
