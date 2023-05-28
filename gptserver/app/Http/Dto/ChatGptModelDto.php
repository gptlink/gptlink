<?php

namespace App\Http\Dto;

use App\Model\ChatGptModel;
use Cblink\Dto\Dto;

/**
 * @property int $user_id 用户id
 * @property string $icon 图标
 * @property string $name 名称
 * @property string $prompt 提示语
 * @property string $system 角色模型指令
 * @property string $status 状态
 * @property string $sort 排序
 * @property string $platform 平台
 * @property string $desc 描述
 * @property string $remark 备注
 * @property string $source 来源
 * @property string $type 类型
 * @property string $verify_result 腾讯云审核结果 true or false，false表示有违规内容
 * @property array $verify_data 腾讯云审核数据
 */
class ChatGptModelDto extends Dto
{
    protected $fillable = [
        'user_id', 'icon', 'name', 'prompt', 'system', 'status', 'sort',
        'platform', 'desc', 'remark', 'source', 'type', 'verify_result', 'verify_data'
    ];

    public function getFillableData()
    {
        return [
            'user_id' => $this->getItem('user_id') ?? 0,
            'icon' => $this->getItem('icon') ?? '',
            'name' => $this->getItem('name'),
            'prompt' => $this->getItem('prompt'),
            'system' => $this->getItem('system'),
            'status' => $this->getItem('status'),
            'sort' => $this->getItem('sort', 0),
            'platform' => $this->getItem('platform', ChatGptModel::PLATFORM_GPT),
            'desc' => $this->getItem('desc', ''),
            'remark' => $this->getItem('remark', ''),
            'source' => $this->getItem('source', ChatGptModel::SOURCE_PLATFORM),
            'type' => $this->getItem('type'),
        ];
    }

    public function getUpdateData()
    {
        return [
            'icon' => $this->getItem('icon'),
            'name' => $this->getItem('name'),
            'prompt' => $this->getItem('prompt'),
            'system' => $this->getItem('system'),
            'desc' => $this->getItem('desc', ''),
            'remark' => $this->getItem('remark', ''),
            'type' => $this->getItem('type'),
        ];
    }
}
