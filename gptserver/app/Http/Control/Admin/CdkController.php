<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\CdkGroupDto;
use App\Http\Request\Admin\CdkGroupRequest;
use App\Http\Resource\Admin\CdkGroupCollection;
use App\Http\Resource\Admin\CdkGroupResource;
use App\Http\Resource\Admin\CdkListCollection;
use App\Http\Service\ExcelService;
use App\Model\Cdk;
use App\Model\CdkGroup;
use Cblink\HyperfExt\BaseController;

class CdkController extends BaseController
{
    /**
     * cdk列表
     * @return CdkListCollection
     */
    public function index()
    {
        $cdks = Cdk::query()
            ->search([
                'name' => ['type' => 'keyword', 'relate' => 'group', 'before' => '%'],
                'code' => ['type' => 'eq'],
                'group_id' => ['type' => 'eq'],
                'status' => ['type' => 'in'],
                'created_at' => ['type' => 'date'],
                'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
                'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
            ])
            ->whenWith([
                'member' => ['member:id,nickname,mobile'],
                'package' => ['package:id,name,expired_day,num,price'],
                'group' => ['group:id,name'],
            ])
            ->orderByDesc('created_at')
            ->pageOrAll();

        return new CdkListCollection($cdks);
    }

    /**
     * CDK批次分组列表
     *
     * @return CdkGroupCollection
     */
    public function group()
    {
        $groups = CdkGroup::query()
            ->search([
                'name' => ['type' => 'keyword', 'before' => '%'],
                'status' => ['type' => 'in'],
                'created_at' => ['type' => 'date'],
            ])
            ->whenWith([
                'package' => ['package:id,name,expired_day,num,price'],
            ])
            ->orderByDesc('created_at')
            ->page();

        return new CdkGroupCollection($groups);
    }

    /**
     * 批次详情
     *
     * @param $id
     * @return CdkGroupResource
     */
    public function show($id)
    {
        $group = CdkGroup::query()
            ->whenWith([
                'package' => ['package:id,name,expired_day,num,price'],
            ])
            ->findOrFail($id);

        return new CdkGroupResource($group);
    }

    /**
     * 添加Cdk
     * @param CdkGroupRequest $request
     * @return CdkGroupResource
     */
    public function store(CdkGroupRequest $request)
    {
        $group = CdkGroup::createByDto(new CdkGroupDto($request->validated()));

        return new CdkGroupResource($group);
    }

    /**
     * 修改cdk批次组
     * @param $id
     * @param CdkGroupRequest $request
     * @return CdkGroupResource
     */
    public function update($id, CdkGroupRequest $request)
    {
        $group = CdkGroup::query()->findOrFail($id);
        $group->updateByDto(new CdkGroupDto($request->validated()));

        return new CdkGroupResource($group);
    }

    /**
     * 导出cdk
     * @param ExcelService $service
     * @return \Psr\Http\Message\ResponseInterface|void
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(ExcelService $service)
    {
        $cdks = Cdk::query()
            ->search([
                'name' => ['type' => 'keyword', 'relate' => 'group', 'before' => '%'],
                'code' => ['type' => 'eq'],
                'group_id' => ['type' => 'eq'],
                'status' => ['type' => 'in'],
                'created_at' => ['type' => 'date'],
                'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
                'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
            ])
            ->whenWith([
                'member' => ['member:id,nickname,mobile'],
                'package' => ['package:id,name,expired_day,num,price'],
                'group' => ['group:id,name'],
            ])
            ->orderByDesc('created_at')
            ->pageOrAll();

        if (empty($cdks)) {
            return $this->success();
        }

        $group = $cdks->first();
        // 导出
        return $service->export(
            sprintf('%s兑换码导出', $group->group->name ?? ''),
            ['编号', '套餐名称', '问答机会', '兑换码', '用户昵称', '用户手机号', '兑换时间', '使用状态'],
            $service->formatData($cdks)
        );
    }
}
