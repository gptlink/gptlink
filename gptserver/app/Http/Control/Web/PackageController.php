<?php

namespace App\Http\Control\Web;

use App\Http\Resource\PackageCollection;
use App\Model\Member;
use App\Model\MemberIdentity;
use App\Model\Package;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;

class PackageController extends BaseController
{
    /**
     * 套餐列表
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(RequestInterface $request)
    {
        $business_id = (int) $request->input('business_id', 0);

        $packages = Package::query()
            ->search([
                'show' => ['value' => Package::SHOW_ON],
                'type' => ['type' => 'eq'],
                'platform' => ['type' => 'eq', 'value' => $request->input('platform', Package::PLATFORM_GPT)],
                'business_id' => ['type' => 'in', 'value' => array_unique([$business_id, 0])],
            ])
            ->orderByDesc('sort')
            ->get();

        return new PackageCollection($packages, $business_id);
    }
}
