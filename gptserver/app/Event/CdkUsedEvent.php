<?php

namespace App\Event;

use App\Model\Cdk;

class CdkUsedEvent
{
    /**
     * @var Cdk
     */
    public $cdk;

    public function __construct(Cdk $cdk)
    {
        $this->cdk = $cdk;
    }

}
