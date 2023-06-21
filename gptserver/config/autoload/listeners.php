<?php

declare(strict_types=1);

return [
    \App\Listener\Order\OrderPaidListener::class,
    \App\Listener\Order\SalesmanOrderPaidListener::class,
    \App\Listener\Order\SalesmanOrderCreateListener::class,
    \App\Listener\Order\CdkUsedListener::class,
    \App\Listener\Task\TaskRecordListener::class,
    \App\Listener\Member\UserRegisterTaskListener::class,
];
