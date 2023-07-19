<?php

namespace App\Job;

use App\Model\Member;
use App\Model\Task;
use Hyperf\AsyncQueue\Job;

class UserRegisterRecordJob extends Job
{
    protected $userId;

    protected $shareOpenid;

    public function __construct($userId, $shareOpenid)
    {
        $this->userId = $userId;
        $this->shareOpenid = $shareOpenid;
    }

    public function handle()
    {
        // 新用户注册任务
        $this->registerTask();

        // 如果不存在分享者 openid 不处理任务与客户绑定
        if ($this->shareOpenid) {
            $shareMember = Member::query()->where(['code' => $this->shareOpenid])->first();
            if (! $shareMember) {
                return;
            }
            $parentId = $shareMember->id;
            // 任务
            $this->inviteTask($parentId);
        }
    }

    /**
     * 注册任务
     */
    protected function registerTask()
    {
        Task::completion(Task::TYPE_REGISTER, $this->userId);
    }

    /**
     * 邀请任务
     *
     * @param $parentId
     */
    protected function inviteTask($parentId)
    {
        // 邀请好友任务
        logger()->info('user-register-event-invite', [
            'parent_id' => $parentId,
        ]);

        // 发送邀请套餐奖励
        Task::completion(Task::TYPE_INVITE, $parentId, true);
    }
}
