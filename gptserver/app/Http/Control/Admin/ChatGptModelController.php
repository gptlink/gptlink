<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\ChatGptModelDto;
use App\Http\Request\Admin\ChatGptModelStatusRequest;
use App\Http\Request\Admin\ChatGptStoreRequest;
use App\Http\Resource\Admin\ChatGptModelCollection;
use App\Http\Resource\Admin\ChatGptModelResource;
use App\Model\ChatGptModel;
use App\Model\GptModelCollect;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ChatGptModelController extends BaseController
{
    /**
     * @return ChatGptModelCollection
     */
    public function index(RequestInterface $request)
    {
        $models = ChatGptModel::query()
            ->search([
                'type' => ['type' => 'eq'],
                'name' => ['type' => 'keyword'],
                'status' => ['type' => 'eq'],
                'source' => ['type' => 'eq'],
                'platform' => ['type' => 'eq'],
                'nickname' => ['type' => 'keyword', 'field' => 'nickname', 'relate' => 'member'],
                'mobile' => ['type' => 'keyword', 'field' => 'mobile', 'relate' => 'member'],
            ])
            ->whenWith([
                'member' => 'member:id,nickname,mobile',
            ])
            ->leftjoin('chat_gpt_model_count', 'chat_gpt_model.id', '=', 'chat_gpt_model_count.chat_gpt_model_id')
            ->orderByDesc('sort')
            ->orderByDesc('uses')
            ->orderByDesc('created_at')
            ->select([
                'id', 'user_id', 'icon', 'name', 'prompt', 'system', 'status',
                'type', 'desc', 'sort', 'source', 'uses', 'likes', 'remark', 'created_at'
            ])
            ->page();

        return new ChatGptModelCollection($models);
    }

    /**
     * @param $id
     * @return ChatGptModelResource
     */
    public function show($id)
    {
        $model = ChatGptModel::query()->where(['id' => $id])
            ->select([
                'id', 'user_id', 'icon', 'name', 'prompt', 'system', 'status', 'sort',
                'platform', 'desc', 'remark', 'type'
            ])
            ->firstOrFail();

        return new ChatGptModelResource($model);
    }

    /**
     * @param ChatGptStoreRequest $request
     * @return ChatGptModelResource
     */
    public function store(ChatGptStoreRequest $request)
    {
        $model = ChatGptModel::createByDto(new ChatGptModelDto(
                array_merge($request->validated(), [
                    'status' => ChatGptModel::STATUS_OFF
                ]))
        );
        return new ChatGptModelResource($model);
    }

    /**
     * @param $id
     * @param ChatGptStoreRequest $request
     * @return ChatGptModelResource
     */
    public function update($id, ChatGptStoreRequest $request)
    {
        /** @var ChatGptModel $model */
        $model = ChatGptModel::query()->where(['id' => $id])->firstOrFail();
        $model->updateByDto(new ChatGptModelDto($request->validated()));
        return new ChatGptModelResource($model);
    }

    /**
     * 模型删除
     *
     * @param $id
     * @return ResponseInterface
     * @throws \Exception
     */
    public function destroy($id)
    {
        $model = ChatGptModel::query()->findOrFail($id);

        $model->destroyModel();

        return $this->success();
    }

    /**
     * 编辑状态
     *
     * @param $id
     * @param ChatGptModelStatusRequest $request
     * @return ChatGptModelResource
     */
    public function updateStatus($id, ChatGptModelStatusRequest $request)
    {
        /** @var ChatGptModel $model */
        $model = ChatGptModel::query()->where(['id' => $id])->firstOrFail();
        $model = $model->updateStatus($request->input('status'));

        return new ChatGptModelResource($model);
    }

    /**
     * 置顶
     *
     * @param $id
     * @return ChatGptModelResource
     */
    public function top($id)
    {
        /** @var ChatGptModel $model */
        $maxSort = ChatGptModel::query()->max('sort');
        /** @var ChatGptModel $model */
        $model = ChatGptModel::query()->where(['id' => $id])->firstOrFail();
        return new ChatGptModelResource($model->updateSort($maxSort + 1));
    }

    /**
     * 取消置顶
     *
     * @param $id
     * @return ChatGptModelResource
     */
    public function cancelTop($id)
    {
        /** @var ChatGptModel $model */
        $model = ChatGptModel::query()->where(['id' => $id])->firstOrFail();
        return new ChatGptModelResource($model->updateSort(0));
    }
}
