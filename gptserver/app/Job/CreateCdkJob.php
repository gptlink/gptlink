<?php

namespace App\Job;

use App\Model\Cdk;
use Hyperf\AsyncQueue\Job;

class CreateCdkJob extends Job
{
    /**
     * @var object cdk组
     */
    protected $cdkGroup;

    public function __construct($cdkGroup)
    {
        $this->cdkGroup = $cdkGroup;
    }

    public function handle()
    {
        for ($i = 0; $i < $this->cdkGroup->num; $i++) {
            Cdk::generate($this->cdkGroup->package_id, $this->cdkGroup->id);
        }
    }
}
