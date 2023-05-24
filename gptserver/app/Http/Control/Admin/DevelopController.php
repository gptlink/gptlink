<?php

namespace App\Http\Control\Admin;

use App\Http\Resource\Admin\DevelopPackageResource;
use App\Http\Service\DevelopService;
use Cblink\HyperfExt\BaseController;

class DevelopController extends BaseController
{
    /**
     * 获取开发者套餐信息
     * @param DevelopService $service
     * @return DevelopPackageResource
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPackage(DevelopService $service)
    {
        $response = $service->getPackage();

        return new DevelopPackageResource($response);
    }
}
