<?php

namespace App\Http\Request\Admin;

use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Request\BaseFormRequest;
use App\Model\Package;
use App\Model\Task;
use Hyperf\Validation\Rule;

class TaskStoreRequest extends BaseFormRequest
{
    public function rules()
    {
        $type = $this->route('type');
        throw_unless(in_array($type, array_keys(Task::TYPE)), LogicException::class, ErrCode::MODEL_NOT_FOUND);
        return $this->{sprintf('%sRule', $type)}() ?? [];
    }

    /**
     * 注册
     *
     * @return array
     */
    protected function registerRule()
    {
        return [
            'platform' => ['nullable', 'array'],
            'package_id' => ['required', 'integer'],
        ];
    }

    /**
     * 邀请
     *
     * @return array
     */
    protected function inviteRule()
    {
        return [
            'title' => ['required', 'string', 'max:10'],
            'desc' => ['required', 'string', 'max:30'],
            'platform' => ['nullable', 'array'],
            'package_id' => ['required', 'integer'],
            'share_image' => ['nullable', 'string'],
        ];
    }

    /**
     * 分享
     *
     * @return array
     */
    protected function shareRule()
    {
        return [
            'title' => ['required', 'string', 'max:10'],
            'desc' => ['required', 'string', 'max:30'],
            'platform' => ['nullable', 'array'],
            'package_id' => ['required', 'integer'],
            'share_image' => ['nullable', 'string'],
        ];
    }
}
