<?php

namespace Api\Admin;

use App\Model\Cdk;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\CdkFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class CdkTest extends TestCase
{
    use LoginTrait;

    public function testAdminCdkGroupIndex()
    {
        $this->adminLogin();

        CdkFactory::createGroupByData();

        $response = $this->get('/admin/cdk/group', [
            'with_query' => ['package'],
            'name' => '玩官方的',
            'created_at' => '2023-01-01~2023-12-31',
        ]);

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '兑换码组列表',
            'category' => '兑换码',
            'params' => [],
            'desc' => '【原型页面兑换码 - 兑换码列表】',
            'request' => [
                'with_query' => 'package 关联套餐',
                'name' => '分组名称搜索',
                'created_at' => '时间区间： 2023-01-01~2023-12-31',
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '兑换码批次号',
                '*.num' => '生成数量',
                '*.name' => '分组名称',
                '*.package_id' => '关联的套餐id',
                '*.created_at' => '创建时间',
                '*.package' => '套餐信息',
                '*.package.id' => '套餐id',
                '*.package.name' => '套餐名称',
                '*.package.price' => '套餐价格',
                '*.package.num' => '套餐内次数，如果为-1则表示不限制',
                '*.package.expired_day' => '有效期，单位天，0表示不限制时间',
            ],
        ]));
    }

    public function testAdminCdkGroupStore()
    {
        $this->adminLogin();

        $response = $this->post('/admin/cdk', [
            'name' => '彩旗公司',
            'package_id' => 16,
            'num' => '10',
            'remark' => '这个是备注信息',
        ]);

        $this->assertApiSuccess($response);

        CdkFactory::deleteById(Arr::get($response->response(), 'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '新增兑换码',
            'category' => '兑换码',
            'params' => [],
            'desc' => '',
            'request' => [
                'name' => '分组名称',
                'package_id' => '关联的套餐id',
                'num' => '生成兑换码数量',
                'remark' => '备注信息',
            ],
            'request_except' => [],
            'response' => [
                'id' => '兑换码批次号',
                'name' => '分组名称',
                'num' => '生成兑换码数量',
                'package_id' => '关联的套餐id',
                'remark' => '备注信息',
                'created_at' => '创建时间',
            ],
        ]));
    }

    public function testAdminCdkGroupShow()
    {
        $this->adminLogin();

        $group = CdkFactory::createGroupByData();

        $response = $this->get(sprintf('/admin/cdk/%s', $group->id), [
            'with_query' => ['package'],
        ]);

        $this->assertApiSuccess($response);

        CdkFactory::deleteById(Arr::get($response->response(), 'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '兑换码详情',
            'category' => '兑换码',
            'params' => [
                3 => '兑换码批次号id',
            ],
            'desc' => '',
            'request' => [
                'with_query' => 'package 关联套餐',
            ],
            'request_except' => [],
            'response' => [
                'id' => '兑换码批次号',
                'name' => '分组名称',
                'num' => '生成兑换码数量',
                'package_id' => '关联的套餐id',
                'remark' => '备注信息',
                'created_at' => '创建时间',
                'package' => '套餐信息',
                'package.id' => '套餐id',
                'package.name' => '套餐名称',
                'package.price' => '套餐价格',
                'package.num' => '套餐内次数，如果为-1则表示不限制',
                'package.expired_day' => '有效期，单位天，0表示不限制时间',
            ],
        ]));
    }

    public function testAdminCdkGroupUpdate()
    {
        $this->adminLogin();

        $group = CdkFactory::createGroupByData();

        $response = $this->put(sprintf('/admin/cdk/%s', $group->id), [
            'name' => '彩旗公司2',
            'remark' => '这个是备注信息2',
        ]);

        $this->assertApiSuccess($response);

        CdkFactory::deleteById(Arr::get($response->response(), 'data.id'));

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '修改兑换码',
            'category' => '兑换码',
            'params' => [
                3 => '兑换码组ID'
            ],
            'desc' => '',
            'request' => [
                'name' => '分组名称',
                'remark' => '备注信息',
            ],
            'request_except' => [],
            'response' => [
                'id' => '兑换码批次号',
                'name' => '分组名称',
                'num' => '生成兑换码数量',
                'package_id' => '关联的套餐id',
                'remark' => '备注信息',
                'created_at' => '创建时间',
            ],
        ]));
    }

    public function testAdminCdkIndex()
    {
        $this->adminLogin();

        $package = PackageFactory::createByData();
        $group = CdkFactory::createGroupByData(['package_id' => $package->id]);
        $cdk = CdkFactory::createCdksByGroup(10, $group->package_id, $group->id);

        $response = $this->get('/admin/cdk', [
            'with_query' => ['package', 'member', 'group'],
            'name' => $group->name,
            'code' => $cdk->code,
            'nickname' => '',
            'mobile' => '',
            'status' => Cdk::STATUS_INIT,
            'group_id' => $group->id,
            'created_at' => '2023-01-01~2023-12-31',
        ]);

        PackageFactory::truncate();
        CdkFactory::truncate();

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '兑换码列表',
            'category' => '兑换码',
            'params' => [],
            'desc' => '【原型页面兑换码 - 查询兑换码】',
            'request' => [
                'with_query' => 'package 关联套餐 member 关联用户 group 关联批次',
                'name' => '分组名称搜索',
                'code' => '兑换码搜索',
                'nickname' => '用户昵称搜索',
                'mobile' => "用户手机号搜索",
                'group_id' => '批次id 用于在批次详情中查看兑换码列表',
                'status' => BaseDto::mapDesc('使用状态', Cdk::STATUS),
                'created_at' => '时间区间： 2023-01-01~2023-12-31',
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '兑换码批次号',
                '*.name' => '分组名称',
                '*.code' => '兑换码',
                '*.user_id' => '用户id',
                '*.group_id' => '批次id',
                '*.package_id' => '关联的套餐id',
                '*.status' => BaseDto::mapDesc('状态', Cdk::STATUS),
                '*.created_at' => '创建时间',
                '*.updated_at' => '兑换时间',
                '*.package' => '套餐信息',
                '*.package.id' => '套餐id',
                '*.package.name' => '套餐名称',
                '*.package.price' => '套餐价格',
                '*.package.num' => '套餐内次数，如果为-1则表示不限制',
                '*.package.expired_day' => '有效期，单位天，0表示不限制时间',
                '*.member' => '用户信息',
                '*.member.nickname' => '用户昵称',
                '*.member.mobile' => '用户手机号',
                '*.group' => '批次信息',
                '*.group.id' => '批次id',
                '*.group.name' => '分组名称',
            ],
        ]));
    }

    public function testAdminCdkExport()
    {
        $this->adminLogin();

        $group = CdkFactory::createGroupByData();
        CdkFactory::createCdksByGroup(10, $group->package_id, $group->id);

        $response = $this->get('/admin/cdk/export', [
            'with_query' => ['package', 'member', 'group'],
            'is_all' => 'true',
            'name' => '姐有彩',
            'code' => 'L4W6Rs2i9rftxP2Iz8wj',
            'nickname' => '十二',
            'mobile' => "18902470300",
            'status' => Cdk::STATUS_USED,
            'group_id' => 14,
            'created_at' => '2023-01-01~2023-12-31',
        ]);

        $this->assertNull($response->response());

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '下载兑换码',
            'category' => '兑换码',
            'params' => [],
            'desc' => '直接访问接口，导出兑换码列表，文件流自动下载',
            'request' => [
                'with_query' => 'package 关联套餐 member 关联用户 group 关联批次',
                'name' => '分组名称搜索',
                'is_all' => '获取全部数据传true 【必传参数】',
                'code' => '兑换码搜索',
                'nickname' => '用户昵称搜索',
                'mobile' => "用户手机号搜索",
                'group_id' => '【必传】批次id 用于在批次详情中查看兑换码列表',
                'status' => BaseDto::mapDesc('使用状态', Cdk::STATUS),
                'created_at' => '时间区间： 2023-01-01~2023-12-31',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
