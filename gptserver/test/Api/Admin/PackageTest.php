<?php

namespace HyperfTest\Api\Admin;

use App\Model\Package;
use Hyperf\Utils\Arr;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class PackageTest extends TestCase
{
    use LoginTrait;

    public function testAdminPackageIndex()
    {
        $this->AdminLogin();

        $package = PackageFactory::createByData(['code' => substr(md5((string) time()), 0, 17) . rand(111, 999)]);

        $response = $this->get('/admin/package', [
            'name' => '',
            'type' => '',
            'identity' => '',
            'code' => '',
            'show_name' => '',
            'show' => '',
        ]);

        $this->assertApiSuccess($response);

        PackageFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '套餐列表',
            'category' => '套餐管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'name' => '套餐名称关键词搜素',
                'type' => BaseDto::mapDesc('套餐类型', Package::TYPE),
                'identity' => BaseDto::mapDesc('适用身份筛选', Package::IDENTITY),
                'code' => '套餐名称关键词搜素',
                'show_name' => '展示名称搜索',
                'show' => BaseDto::mapDesc('是否显示', Package::SHOW),
            ],
            'request_except' => [
                'name', 'type', 'identity', 'code',
                'show_name', 'show',
            ],
            'response' => [
                '*.id' => 1,
                '*.name' => '套餐名称',
                '*.identity' => BaseDto::mapDesc('套餐身份', Package::IDENTITY),
                '*.show_name' => '套餐展示名称',
                '*.code' => '标识',
                '*.type' => BaseDto::mapDesc('类型', Package::TYPE),
                '*.expired_day' => '有效天数',
                '*.num' => '数量 -1 不限数量',
                '*.price' => '价格',
                '*.level' => '扣费优先级',
                '*.sort' => '序号',
                '*.show' => BaseDto::mapDesc('是否展示', Package::SHOW),
                '*.order_count' => '下单数量',
                '*.order_sum_payment' => '实付金额',
            ],
        ]));
    }

    public function testAdminPackageShow()
    {
        $this->AdminLogin();
        $package = PackageFactory::createByData(['code' => substr(md5((string) time()), 0, 17) . rand(111, 999)]);

        $response = $this->get(sprintf('/admin/package/%s', $package->id));
        $this->assertApiSuccess($response);
        $package->delete();
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '套餐详情',
            'category' => '套餐管理',
            'params' => [3 => '套餐 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => '套餐 id',
                'name' => '套餐名称',
                'type' => BaseDto::mapDesc('类型', Package::TYPE),
                'expired_day' => '有效天数',
                'num' => '数量',
                'price' => '价格',
                'identity' => BaseDto::mapDesc('套餐身份', Package::IDENTITY),
                'code' => '标识',
                'sort' => '权重',
                'level' => '等级',
                'show' => '是否展示',
            ],
        ]));
    }

    // 创建套餐
    public function testAdminPackageStore()
    {
        $this->AdminLogin();

        $response = $this->post('/admin/package', [
            'name' => '套餐名称',
            'type' => Package::TYPE_CHAT,
            'sort' => 10,
            'expired_day' => 15,
            'num' => 1,
            'price' => '100.01',
            'level' => 1,
            'identity' => Package::IDENTITY_USER,
            'show_name' => '展示套餐名称',
            'code' => substr(md5((string) time()), 0, 17) . rand(111, 999),
        ]);

        $this->assertApiSuccess($response);
        PackageFactory::deleteById(Arr::get($response->response(), 'data.id'));
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '新增套餐',
            'category' => '套餐管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'name' => '套餐名称',
                'show_name' => '展示套餐名称',
                'type' => BaseDto::mapDesc('类型: ', Package::TYPE),
                'sort' => '排序',
                'identity' => BaseDto::mapDesc('适用身份', Package::IDENTITY),
                'expired_day' => '有效天数',
                'num' => '数量;-1不限数量',
                'price' => '价格(元)',
                'level' => '等级越高优先扣除',
                'code' => '20 位的唯一套餐标识',
            ],
            'request_except' => ['code'],
            'response' => [
                'id' => '套餐 id',
                'name' => '套餐名称',
                'type' => BaseDto::mapDesc('类型', Package::TYPE),
                'expired_day' => '有效天数',
                'num' => '数量',
                'price' => '价格',
                'identity' => '适用身份',
                'code' => '表别标识',
                'sort' => '权重',
                'level' => '等级',
                'show' => '是否展示',
            ],
        ]));
    }

    // 编辑
    public function testAdminPackageUpdate()
    {
        $this->AdminLogin();
        $package = PackageFactory::createByData(['code' => substr(md5((string) time()), 0, 17) . rand(111, 999)]);
        $response = $this->put(sprintf('/admin/package/%s', $package->id), [
            'name' => '套餐名称',
            'type' => Package::TYPE_CHAT,
            'sort' => 1,
            'expired_day' => 10,
            'num' => 100,
            'price' => '100.01',
            'level' => 1,
            'show_name' => '展示套餐名称',
            'code' => substr(md5((string) time()), 0, 17) . rand(111, 999),
        ]);
        $this->assertApiSuccess($response);
        PackageFactory::deleteById($package->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '编辑套餐',
            'category' => '套餐管理',
            'params' => [3 => '套餐 id'],
            'desc' => '',
            'request' => [
                'name' => '套餐名称',
                'show_name' => '展示套餐名称',
                'type' => BaseDto::mapDesc('类型: ', Package::TYPE),
                'sort' => '排序',
                'expired_day' => '有效天数',
                'num' => '数量;-1不限数量',
                'price' => '价格(元)',
                'level' => '等级越高优先扣除',
                'code' => '20 位的唯一套餐标识',
            ],
            'request_except' => ['code'],
            'response' => [],
        ]));
    }

    // 编辑是否展示
    public function testAdminPackageUpdateShow()
    {
        $this->AdminLogin();
        $package = PackageFactory::createByData(['code' => substr(md5((string) time()), 0, 17) . rand(111, 999)]);
        $response = $this->put(sprintf('/admin/package/%s/show', $package->id));
        $this->assertApiSuccess($response);
        PackageFactory::deleteById($package->id);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '编辑套餐是否展示',
            'category' => '套餐管理',
            'params' => [3 => '套餐 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [],
        ]));
    }

    public function testAdminPackageDestroy()
    {
        $this->AdminLogin();

        $package = PackageFactory::createByData(['code' => substr(md5((string) time()), 0, 17) . rand(111, 999)]);

        $response = $this->delete(sprintf('/admin/package/%s', $package->id));

        $this->assertApiSuccess($response);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '删除套餐',
            'category' => '套餐管理',
            'params' => [3 => '套餐 id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
