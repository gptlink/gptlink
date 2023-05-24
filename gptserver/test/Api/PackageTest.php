<?php

namespace HyperfTest\Api;

use App\Model\Package;
use Cblink\Hyperf\Yapi\Dto;
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

    public function testWebPackageIndex()
    {
        $this->userLogin();

        $package = PackageFactory::createByData();

        $response = $this->get('/package');

        $this->assertApiSuccess($response);

        $package->delete();

        $response->build(new BaseDto([
            'project' => ['default'],
            'name' => '套餐列表',
            'category' => '套餐相关',
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 'id',
                '*.name' => '套餐名称',
                '*.type' => BaseDto::mapDesc('套餐类型', Package::TYPE),
                '*.sort' => '排序',
                '*.expired_day' => '有效期，单位天，0表示不限制时间',
                '*.num' => '套餐内次数，如果为-1则表示不限制',
                '*.price' => '售价(元)',
            ],
        ]));
    }
}
