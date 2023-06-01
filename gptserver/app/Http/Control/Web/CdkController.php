<?php

namespace App\Http\Control\Web;

use App\Http\Request\Web\CdkExchangeRequest;
use App\Http\Resource\PackageResource;
use App\Model\Cdk;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class CdkController extends BaseController
{
    /**
     * 兑换码
     *
     * @param CdkExchangeRequest $request
     * @param LimitService $service
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function exchange(CdkExchangeRequest $request)
    {
        $package = Cdk::exchange($request->input('cdk'), auth()->id());

        return new PackageResource($package);
    }
}
