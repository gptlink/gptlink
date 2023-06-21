<?php

use App\Http\Control as Api;
use Hyperf\HttpServer\Router\Router;

// 通知路由
Router::post('/hook/{orderNo}/paid', [Api\Hook\WechatPayController::class, 'hook']);
