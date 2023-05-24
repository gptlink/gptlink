<?php

namespace App\Listener\Member;

use App\Event\UserRegisterTaskEvent;
use App\Model\Member;
use App\Model\Task;
use App\Model\UserTree;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * 所有任务完成触发
 */
class UserRegisterTaskListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            UserRegisterTaskEvent::class,
        ];
    }

    /**
     * @param UserRegisterTaskEvent $event
     */
    public function process(object $event)
    {
        // 用户 id
        $userId = $event->userId;
        $shareOpenid = $event->shareOpenid;

        // 新用户注册任务
        $this->registerTask($userId);
        logger()->info('user-register-event', [
            'user_id' => $userId,
            'share_openid' => $shareOpenid,
        ]);
        // 如果不存在分享者 openid 不处理任务与客户绑定
        $parentId = 0;
        if ($shareOpenid) {
            $shareMember = Member::query()->where(['code' => $shareOpenid])->first();
            if (! $shareMember) {
                return;
            }
            $parentId = $shareMember->id;
            // 任务
            $this->inviteTask($parentId);
        }

        // 记录用户关系
        UserTree::query()->create([
            'user_id' => $userId,
            'parent_id' => $parentId,
            'parent_code_id' => $shareOpenid ?? '',
        ]);
    }

    /**
     * 注册任务
     *
     * @param $userId
     */
    protected function registerTask($userId)
    {
        Task::completion(Task::TYPE_REGISTER, $userId);
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
