<?php

declare(strict_types=1);

namespace App\Process;

use Hyperf\AsyncQueue\Process\ConsumerProcess;
use Hyperf\Process\Annotation\Process;

/**
 * @Process
 */
class AsyncQueueConsumer extends ConsumerProcess
{
}
