<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\PackageDto;
use App\Http\Request\Admin\PackageStoreRequest;
use App\Http\Resource\Admin\PackageCollection;
use App\Http\Resource\Admin\PackageResource;
use App\Model\Order;
use App\Model\Package;
use Cblink\HyperfExt\BaseController;
use Psr\Http\Message\ResponseInterface;

class PackageController extends BaseController
{
    /**
     * 套餐列表
     *
     * @return PackageCollection
     */
    public function index()
    {
        $packages = Package::query()
            ->search([
                'name' => ['type' => 'keyword', 'before' => '%'],
                'type' => ['type' => 'in'],
                'identity' => ['type' => 'in'],
                'code' => ['type' => 'keyword', 'before' => '%'],
                'show_name' => ['type' => 'keyword', 'before' => '%'],
                'show' => ['type' => 'in'],
            ])
            ->withCount(['order' => function ($query) {
                $query->where('status', Order::STATUS_PAID);
            }])
            ->withSum(['order' => function ($query) {
                $query->where('status', Order::STATUS_PAID);
            }], 'payment')
            ->orderByDesc('sort')
            ->get();

        return new PackageCollection($packages);
    }

    /**
     * 详情
     *
     * @param $id
     * @return PackageResource
     */
    public function show($id)
    {
        $package = Package::query()->findOrFail($id);
        return new PackageResource($package);
    }

    /**
     * @param PackageStoreRequest $request
     * @return PackageResource
     */
    public function store(PackageStoreRequest $request): PackageResource
    {
        $package = Package::createByDto(new PackageDto($request->validated()));

        return new PackageResource($package);
    }

    /**
     * 修改
     *
     * @param $id
     * @param PackageStoreRequest $request
     * @return ResponseInterface
     */
    public function update($id, PackageStoreRequest $request)
    {
        $package = Package::query()->findOrFail($id);

        $package->updateByDto(new PackageDto($request->validated()));

        return $this->success();
    }

    /**
     * 修改状态
     *
     * @param $id
     * @return ResponseInterface
     */
    public function updateShow($id)
    {
        $package = Package::query()->findOrFail($id);

        $show = $package->show == Package::SHOW_ON ? Package::SHOW_OFF : Package::SHOW_ON;

        $package->updateShow($show);

        return $this->success();
    }
}
