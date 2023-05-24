<?php

namespace HyperfTest\Api\Admin;

use App\Model\Member;
use App\Model\MemberPackage;
use App\Model\Package;
use Cblink\Hyperf\Yapi\Dto;
use HyperfTest\Factory\MemberFactory;
use HyperfTest\Factory\MemberPackageFactory;
use HyperfTest\Factory\PackageFactory;
use HyperfTest\LoginTrait;
use HyperfTest\TestCase;
use HyperfTest\TestDto\BaseDto;

/**
 * @internal
 * @coversNothing
 */
class MemberTest extends TestCase
{
    use LoginTrait;

    public function testAdminMemberIndex()
    {
        $this->adminLogin();

        MemberFactory::createByData();

        $response = $this->get('/admin/member', [
            'nickname' => '',
            'mobile' => '',
            'status' => '',
            'platform' => '',
            'business_id' => '',
        ]);

        $this->assertApiSuccess($response);

        MemberFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '用户列表',
            'category' => '用户管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'nickname' => '昵称',
                'mobile' => '手机号',
                'status' => BaseDto::mapDesc('用户状态', Member::STATUS),
                'platform' => BaseDto::mapDesc('注册平台', Member::PLATFORM),
                'business_id' => '来源商户/模型ID',
            ],
            'request_except' => ['nickname', 'mobile'],
            'response' => [
                '*.id' => 'id',
                '*.nickname' => '用户昵称',
                '*.avatar' => '用户头像',
                '*.register_at' => '注册时间',
                '*.mobile' => '手机号',
                '*.status' => BaseDto::mapDesc('用户状态', Member::STATUS),
                '*.platform' => BaseDto::mapDesc('注册平台', Member::PLATFORM),
                '*.business_id' => '来源商户/模型ID',
                '*.source' => '来源渠道，字符串标识',
            ],
        ]));
    }

    public function testAdminMemberGetPackage()
    {
        $this->adminLogin();
        $userId = 1;
        $memberPackage = MemberPackageFactory::createByData(['user_id' => $userId, 'status' => MemberPackage::STATUS_AVAILABLE]);
        $response = $this->get(sprintf('/admin/member/%s/package', $userId));

        $this->assertApiSuccess($response);
        $memberPackage->delete();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '用户可用套餐列表',
            'category' => '用户管理',
            'params' => [3 => 'user id'],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                '*.id' => 1,
                '*.name' => '套餐名称',
                '*.user_id' => '用户 id',
                '*.channel' => BaseDto::mapDesc('套餐来源渠道', MemberPackage::CHANNEL),
                '*.type' => BaseDto::mapDesc('套餐类型', Package::TYPE),
                '*.num' => '数量(-1 为不限数量)',
                '*.used' => '使用量',
                '*.expired_at' => '失效时间YYYY-MM-DD',
            ],
        ]));
    }

    public function testAdminMemberGivePackage()
    {
        $this->adminLogin();
        $userId = 1;
        $package = PackageFactory::createByData();
        $response = $this->post(sprintf('/admin/member/%s/package', $userId), [
            'package_id' => $package->id,
        ]);
        $package->delete();
        $this->assertApiSuccess($response);
        PackageFactory::deleteById($package->id);
        MemberPackageFactory::deleteById($userId);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '赠送套餐',
            'category' => '用户管理',
            'params' => [
                3 => 'user id',
            ],
            'desc' => '',
            'request' => [
                'package_id' => '套餐 id 通过套餐列表获取',
            ],
            'request_except' => [],
            'response' => [
            ],
        ]));
    }

    public function testAdminGetMemberPackageRecord()
    {
        $this->adminLogin();

        $package = PackageFactory::createByData();
        $package->sendToUser(1);

        $response = $this->get('/admin/member/package/record', [
            'with_query' => ['member'],
            'nickname' => '',
            'mobile' => '',
            'channel' => '',
            'type' => '',
            'user_id' => ''
        ]);

        $this->assertApiSuccess($response);

        PackageFactory::truncate();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '获取用户套餐记录',
            'category' => '用户管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'with_query' => 'array：数组 member 用户信息',
                'nickname' => '昵称搜索',
                'mobile' => '昵称搜索',
                'channel' => BaseDto::mapDesc('渠道筛选', MemberPackage::CHANNEL),
                'type' => BaseDto::mapDesc('类型', Package::TYPE),
                'user_id' => '用户 id'
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '记录ID',
                '*.user_id' => '用户ID',
                '*.package_id' => '套餐ID',
                '*.package_name' => '套餐名称（历史）',
                '*.channel' => BaseDto::mapDesc('渠道筛选', MemberPackage::CHANNEL),
                '*.type' => BaseDto::mapDesc('类型', Package::TYPE),
                '*.code' => '套餐标识',
                '*.expired_day' => '有效期，单位天',
                '*.num' => '数量，-1表示不限制',
                '*.created_at' => '创建时间',
                '*.user' => '用户信息',
                '*.user.nickname' => '用户名',
                '*.user.mobile' => '手机号',
            ],
        ]));
    }

    public function testAdminGetMemberDisabledRecord()
    {
        $this->adminLogin();

        MemberFactory::createDisabledByData();

        $response = $this->get('/admin/member/disabled/record', [
            'with_query' => ['member'],
            'nickname' => '1',
            'mobile' => '13200001111',
            'status' => 1,
            'lable' => 'Porn',
        ]);

        $this->assertApiSuccess($response);
        MemberFactory::deleteDisabledRecord();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '用户封禁记录',
            'category' => '用户管理',
            'params' => [],
            'desc' => '',
            'request' => [
                'with_query' => 'array：数组 member 用户信息',
                'nickname' => '昵称搜索',
                'mobile' => '昵称搜索',
                'status' => BaseDto::mapDesc('状态', MemberDisabledRecord::STATUS),
                'lable' => BaseDto::mapDesc('封禁类型', TencentCloudTmsService::LABEL),
            ],
            'request_except' => [],
            'response' => [
                '*.id' => '数据ID',
                '*.member_id' => '用户ID',
                '*.trigger' => '触发关键词',
                '*.content' => '原内容',
                '*.lable' => BaseDto::mapDesc('封禁类型', TencentCloudTmsService::LABEL),
                '*.appeal' => '申诉内容',
                '*.mobile' => '联系方式',
                '*.reason' => '驳回原因',
                '*.status' => BaseDto::mapDesc('状态', MemberDisabledRecord::STATUS),
                '*.apply_at' => '申请时间',
                '*.disabled_at' => '封禁时间',
                '*.enabled_at' => '解封时间',
                '*.user' => '用户信息',
                '*.user.nickname' => '用户名',
                '*.user.mobile' => '手机号',
            ],
        ]));
    }

    public function testAdminMemberDisabledRecordShow()
    {
        $this->adminLogin();

        $record = MemberFactory::createDisabledByData();

        $response = $this->get(sprintf('/admin/member/%s/record', $record->id), [
            'with_query' => ['member',],
        ]);

        $this->assertApiSuccess($response);
        MemberFactory::deleteDisabledRecord();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '封禁记录详情',
            'category' => '用户管理',
            'params' => [
                3 => '封禁记录id',
            ],
            'desc' => '',
            'request' => [
                'with_query' => 'array：数组 member 用户信息 identity 身份信息',
            ],
            'request_except' => [],
            'response' => [
                'id' => '封禁记录ID',
                'member_id' => '用户ID',
                'lable' => 'Porn：色情，Abuse：谩骂，Ad：广告',
                'trigger' => '触发关键词',
                'content' => '原内容',
                'appeal' => '申诉内容',
                'reason' => '备注原因',
                'enabled_at' => '操作时间',
                'mobile' => '联系方式',
                'status' => BaseDto::mapDesc('违禁状态', MemberDisabledRecord::STATUS),
                'disabled_at' => '封禁时间',
                'records_count' => '历史封禁次数',
                'user' => '用户信息',
                'user.nickname' => '用户名',
                'user.mobile' => '手机号',
            ],
        ]));
    }

    // 手动封号
    public function testAdminMemberUpdateStatus()
    {
        $this->adminLogin();
        $member = MemberFactory::createByData();
        $response = $this->put(sprintf('/admin/member/%s/status', $member->id));
        $response->dump();
        MemberFactory::deleteById($member->id);
        $this->assertApiSuccess($response);
        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '封禁/正常',
            'category' => '用户管理',
            'params' => [
                3 => 'user id',
            ],
            'desc' => '',
            'request' => [],
            'request_except' => [],
            'response' => [
                'id' => 'id',
                'nickname' => '用户昵称',
                'avatar' => '用户头像',
                'register_at' => '注册时间',
                'mobile' => '手机号',
                'status' => BaseDto::mapDesc('用户状态', Member::STATUS),
            ],
        ]));
    }

    public function testAdminUnlockMember()
    {
        $this->adminLogin();

        $record = MemberFactory::createDisabledByData();

        $response = $this->put(sprintf('/admin/member/%s/unlock', $record->id), [
            'reason' => '测试解封',
        ]);

        $this->assertApiSuccess($response);
        MemberFactory::deleteDisabledRecord();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '解除封禁',
            'category' => '用户管理',
            'params' => [
                3 => '封禁记录id',
            ],
            'desc' => '',
            'request' => [
                'reason' => '备注原因 选填',
            ],
            'request_except' => ['reason'],
            'response' => [],
        ]));
    }

    public function testAdminRejectMember()
    {
        $this->adminLogin();

        $record = MemberFactory::createDisabledByData();

        $response = $this->put(sprintf('/admin/member/%s/reject', $record->id), [
            'reason' => '测试驳回',
        ]);

        $this->assertApiSuccess($response);
        MemberFactory::deleteDisabledRecord();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '驳回封禁申诉',
            'category' => '用户管理',
            'params' => [
                3 => '封禁记录id',
            ],
            'desc' => '',
            'request' => [
                'reason' => '驳回原因 【注意驳回时必填】',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

    // 封禁记录列表
    public function testAdminDisabledMember()
    {
        $this->adminLogin();

        $record = MemberFactory::createDisabledByData();

        $response = $this->put(sprintf('/admin/member/%s/disabled', $record->id), [
            'reason' => '测试封号，就是要封号',
        ]);

        $this->assertApiSuccess($response);
        MemberFactory::deleteDisabledRecord();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '封禁用户',
            'category' => '用户管理',
            'params' => [
                3 => '封禁记录id',
            ],
            'desc' => '',
            'request' => [
                'reason' => '备注原因必填',
            ],
            'request_except' => [],
            'response' => [],
        ]));
    }

    // 微信记录
    public function testAdminMemberWechatOauth()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        MemberFactory::createOauth($member->id);

        $response = $this->get('/admin/member/wechat-oauth/record', ['user_id' => $member->id]);
        $response->dump();
        $this->assertApiSuccess($response);
        MemberFactory::deleteById($member->id);

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '微信授权记录',
            'category' => '用户管理',
            'params' => [],
            'desc' => '',
            'request' => ['user_id' => '用户 id'],
            'request_except' => ['user_id'],
            'response' => [
                '*.id' => 'oauth id',
                '*.member_id' => '用户 id',
                '*.nickname' => '用户昵称',
                '*.avatar' => '用户头像',
                '*.unionid' => '用户 unionid',
                '*.openid' => '用户openid',
                '*.platform' => Dto::mapDesc('平台', ['weixin', 'weixinweb']),
                '*.appid' => 'appid',
            ],
        ]));
    }


    // 微信记录
    public function testAdminMemberUnbindWechatOauth()
    {
        $this->adminLogin();

        $member = MemberFactory::createByData();
        $oauth = MemberFactory::createOauth($member->id);
        $response = $this->post('/admin/member/wechat-oauth/unbind', ['member_oauth_id' => $oauth->id]);
        $this->assertApiSuccess($response);
        $member->delete();
        $oauth->delete();

        $response->build(new BaseDto([
            'project' => ['admin'],
            'name' => '解绑微信授权记录',
            'category' => '用户管理',
            'params' => [],
            'desc' => '',
            'request' => ['member_oauth_id' => '用户 id'],
            'request_except' => [],
            'response' => [],
        ]));
    }
}
