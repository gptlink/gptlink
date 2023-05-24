<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    // 队列调度
    Hyperf\AsyncQueue\Process\ConsumerProcess::class,
    // 定时任务调度
    Hyperf\Crontab\Process\CrontabDispatcherProcess::class,

];
