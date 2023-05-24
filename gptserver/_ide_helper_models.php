<?php
// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author NaiXiaoXin  <i@nxx.email>
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model{
/**
 * App\Model\Material
 *
 * @property integer $id
 * @property integer $type 类型:1.魔法书咒语图片;2.咒语大师形象
 * @property string $title 文件名称
 * @property string $file_url 文件url
 * @property integer $size 大小 bytes
 * @property string $format 格式
 * @property integer $width 宽 px
 * @property integer $height 长 px
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereFileUrl($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereFormat($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereHeight($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereSize($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereTitle($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Material whereWidth($value)
 */
	class Material {}
}

namespace App\Model{
/**
 * App\Model\ChatLog
 *
 * @property integer $id chat_id
 * @property integer $user_id 用户id
 * @property string|null $first_id 首记录id
 * @property string|null $parent_id 父级id
 * @property string|null $system 咒语
 * @property string|null $ask 问题
 * @property string|null $answer 回答
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereAnswer($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereAsk($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereFirstId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereParentId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereSystem($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatLog whereUserId($value)
 */
	class ChatLog {}
}

namespace App\Model{
/**
 * App\Model\Package
 *
 * @property integer $id
 * @property string $name 套餐名称
 * @property string $show_name 展示名称
 * @property integer $identity 身份
 * @property string|null $code 标识，同标识的套餐会累加
 * @property integer $type 类型, 对话，图片生成，等等
 * @property integer $sort 排序，越大越前
 * @property integer $expired_day 有效期，单位天，0表示不限制时间
 * @property integer $num 套餐内次数，如果为-1则表示不限制
 * @property float $price 售价
 * @property integer $level 扣费优先级，越大越优先
 * @property integer $show 是否展示
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property integer $platform 注册平台
 * @property integer $business_id 商户ID/模型ID
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\Order[] $order
 * @property-read int|null $order_count
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereBusinessId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereCode($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereExpiredDay($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereIdentity($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereLevel($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereNum($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package wherePrice($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereShow($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereShowName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereSort($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Package whereUpdatedAt($value)
 */
	class Package {}
}

namespace App\Model{
/**
 * App\Model\Order
 *
 * @property integer $id
 * @property string $trade_no 订单号
 * @property string|null $paid_no 第三方的支付流水号
 * @property integer $user_id 用户ID
 * @property string $channel 支付渠道，微信，支付宝
 * @property string $pay_type 支付类型, h5, native
 * @property float $price 支付金额
 * @property float $payment 实际支付金额
 * @property array $payload 支付参数
 * @property integer $status 支付状态
 * @property integer $package_id 购买的套餐
 * @property string|null $package_name 套餐名称
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property integer $platform 来源平台, gpt-link或aiyaaa
 * @property integer $business_id GPTlink的商户ID/yaiaa的模型ID
 * @property-read \App\Model\Member $member
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whenWith(array $with = [], array $loaded = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereBusinessId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereChannel($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePackageId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePackageName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePaidNo($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePayType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePayload($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePayment($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order wherePrice($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereTradeNo($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Order whereUserId($value)
 */
	class Order {}
}

namespace App\Model{
/**
 * App\Model\Member
 *
 * @property integer $id
 * @property string|null $nickname 用户名
 * @property string|null $avatar 用户头像
 * @property string|null $mobile 手机号
 * @property string $code 用户标识码
 * @property integer $status 状态, 1正常，2禁用
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property integer $platform 注册平台
 * @property integer $business_id 商户ID/模型ID
 * @property string|null $source 注册来源平台
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\MemberOauth[] $oauth
 * @property-read int|null $oauth_count
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\Order[] $order
 * @property-read int|null $order_count
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereAvatar($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereBusinessId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereCode($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereMobile($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereNickname($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereSource($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Member whereUpdatedAt($value)
 */
	class Member {}
}

namespace App\Model{
/**
 * App\Model\Config
 *
 * @property integer $id
 * @property integer $type 配置类型
 * @property array $config 配置项JSON
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config whereConfig($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Config whereUpdatedAt($value)
 */
	class Config {}
}

namespace App\Model{
/**
 * App\Model\Task
 *
 * @property integer $id
 * @property string $type 任务类型
 * @property string|null $title 标题
 * @property string|null $desc 描述
 * @property string $platform 服务应用
 * @property string|null $share_image 背景图
 * @property integer $status 状态:1 开启;2 关闭
 * @property array $rule 规则
 * @property integer $package_id 赠送套餐 id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Package $package
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\TaskRecord[] $record
 * @property-read int|null $record_count
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereDesc($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task wherePackageId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereRule($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereShareImage($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereTitle($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Task whereUpdatedAt($value)
 */
	class Task {}
}

namespace App\Model{
/**
 * App\Model\TaskRecord
 *
 * @property integer $id
 * @property integer $user_id 用户 id
 * @property integer $task_id 任务 id
 * @property string $type 任务类型
 * @property string $package_name 套餐副本名称
 * @property string $expired_day 天数
 * @property integer $num 套餐内次数，如果为-1则表示不限制
 * @property integer $is_read 是否已读:1:已读;2:未读
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Member $member
 * @property-read \App\Model\Package $package
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whenWith(array $with = [], array $loaded = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereExpiredDay($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereIsRead($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereNum($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord wherePackageName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereTaskId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\TaskRecord whereUserId($value)
 */
	class TaskRecord {}
}

namespace App\Model{
/**
 * App\Model\ChatGptModelCount
 *
 * @property string $chat_gpt_model_id 模型 id
 * @property integer $likes 点赞量
 * @property integer $uses 使用量
 * @property-read \App\Model\ChatGptModel $chatGptModel
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount whereChatGptModelId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount whereLikes($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModelCount whereUses($value)
 */
	class ChatGptModelCount {}
}

namespace App\Model{
/**
 * App\Model\ConsumeChat
 *
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ConsumeChat newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ConsumeChat newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ConsumeChat query()
 */
	class ConsumeChat {}
}

namespace App\Model{
/**
 * App\Model\MemberPackageRecord
 *
 * @property integer $id
 * @property integer $user_id 用户ID
 * @property integer $package_id 套餐ID
 * @property integer $identity 套餐身份
 * @property string $package_name 套餐名称
 * @property string|null $code 用户标识
 * @property integer $expired_day 有效期
 * @property integer $num 数量
 * @property integer $channel 套餐渠道, 系统赠送，订单购买，后台操作
 * @property integer $type 类型，与套餐的类型保持一致
 * @property string $created_at 创建时间
 * @property-read \App\Model\Member $member
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whenWith(array $with = [], array $loaded = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereChannel($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereCode($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereExpiredDay($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereIdentity($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereNum($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord wherePackageId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord wherePackageName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackageRecord whereUserId($value)
 */
	class MemberPackageRecord {}
}

namespace App\Model{
/**
 * App\Model\ChatGptModel
 *
 * @property string $id 字符 id
 * @property integer $user_id 用户 id
 * @property string|null $icon 模型图标
 * @property string $name 模型名称
 * @property string|null $prompt 开场提示语
 * @property string $system 咒语
 * @property integer $status 状态:1.启动;2.关闭;3.待审核;4.违规
 * @property integer $sort 排序
 * @property string|null $remark 备注
 * @property string|null $desc 模型描述
 * @property integer $type 1.对话;2.问答
 * @property integer $source 1.平台;2.魔法书
 * @property integer $platform 1.gpt;2.魔法书
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\ChatGptModelCount $countData
 * @property-read \App\Model\Member $member
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel page(array $column = [], int $pageSize = 10, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel pageOrAll(array $column = [], int $pageSize = 10, int $pageLimit = 500, int $maxPageSize = 150, bool $simple = false)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel simplePage($column = [], int $pageSize = 10, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel simplePageOrAll($column = [], $pageSize = 10, $pageLimit = 500, int $maxPageSize = 150)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whenWith(array $with = [], array $loaded = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereDesc($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereIcon($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel wherePrompt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereRemark($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereSort($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereSource($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereSystem($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\ChatGptModel whereUserId($value)
 */
	class ChatGptModel {}
}

namespace App\Model{
/**
 * App\Model\MemberOauth
 *
 * @property integer $id
 * @property integer $member_id 会员 id
 * @property string $platform 第三方平台
 * @property string|null $appid 公众号 appid
 * @property string|null $openid 用户的openid
 * @property string|null $unionid 平台的union_id
 * @property string|null $nickname 用户名
 * @property string|null $avatar 用户头像
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Model\Member $member
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereAppid($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereAvatar($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereMemberId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereNickname($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereOpenid($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth wherePlatform($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereUnionid($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberOauth whereUpdatedAt($value)
 */
	class MemberOauth {}
}

namespace App\Model{
/**
 * App\Model\MemberPackage
 *
 * @property integer $id
 * @property string $name 展示名称，包的show_name
 * @property string|null $code 套餐标识
 * @property integer $user_id 用户
 * @property integer $status 状态
 * @property integer $channel 套餐渠道, 系统赠送，订单购买，后台操作
 * @property integer $type 类型，与套餐的类型保持一致
 * @property integer $num 套餐量, -1表示不限制
 * @property integer $used 用量
 * @property integer $level 扣费优先级，越大越前
 * @property string|null $expired_at 有效期
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage search(array $items, array $attributes = [])
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereChannel($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereCode($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereExpiredAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereLevel($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereName($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereNum($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereType($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereUpdatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereUsed($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\MemberPackage whereUserId($value)
 */
	class MemberPackage {}
}

namespace App\Model{
/**
 * App\Model\Cdk
 *
 * @property integer $id
 * @property integer $package_id 套餐ID
 * @property string $code 兑换码
 * @property integer $user_id 使用的用户
 * @property integer $status 状态
 * @property string|null $expired_at 过期时间
 * @property string $created_at 创建时间
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk newModelQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk newQuery()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk query()
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereCode($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereCreatedAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereExpiredAt($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk wherePackageId($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereStatus($value)
 * @method static \Hyperf\Database\Model\Builder|\App\Model\Cdk whereUserId($value)
 */
	class Cdk {}
}

