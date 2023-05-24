<?php

namespace HyperfTest\Mock;

use App\Http\Service\QiniuService;

class QiniuServiceMock
{
    public static function mock()
    {
        $service = \Mockery::mock(QiniuService::class)->makePartial();
        $service->allows()->getUploadToken()->andReturn('qiniu_token');
        app()->set(QiniuService::class, $service);
    }
}
