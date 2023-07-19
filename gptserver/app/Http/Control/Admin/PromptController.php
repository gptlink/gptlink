<?php

namespace App\Http\Control\Admin;

use App\Http\Dto\PromptDto;
use App\Http\Request\Admin\PromptStatusRequest;
use App\Http\Request\Admin\ChatGptStoreRequest;
use App\Http\Resource\Admin\PromptCollection;
use App\Http\Resource\Admin\PromptResource;
use App\Model\Prompt;
use Cblink\HyperfExt\BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PromptController extends BaseController
{
    /**
     * @return PromptCollection
     */
    public function index(RequestInterface $request)
    {
        $models = Prompt::query()
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
            ->leftjoin('prompt_count', 'prompt.id', '=', 'prompt_count.prompt_id')
            ->orderByDesc('sort')
            ->orderByDesc('uses')
            ->orderByDesc('created_at')
            ->select([
                'id', 'user_id', 'icon', 'name', 'prompt', 'system', 'status',
                'type', 'desc', 'sort', 'source', 'uses', 'likes', 'remark', 'created_at',
            ])
            ->page();

        return new PromptCollection($models);
    }

    /**
     * @param $id
     * @return PromptResource
     */
    public function show($id)
    {
        $model = Prompt::query()->where(['id' => $id])
            ->select([
                'id', 'user_id', 'icon', 'name', 'prompt', 'system', 'status', 'sort',
                'platform', 'desc', 'remark', 'type',
            ])
            ->firstOrFail();

        return new PromptResource($model);
    }

    /**
     * @param ChatGptStoreRequest $request
     * @return PromptResource
     */
    public function store(ChatGptStoreRequest $request)
    {
        $model = Prompt::createByDto(
            new PromptDto(
                array_merge($request->validated(), [
                    'status' => Prompt::STATUS_OFF,
                ])
            )
        );
        return new PromptResource($model);
    }

    /**
     * @param $id
     * @param ChatGptStoreRequest $request
     * @return PromptResource
     */
    public function update($id, ChatGptStoreRequest $request)
    {
        /** @var Prompt $model */
        $model = Prompt::query()->where(['id' => $id])->firstOrFail();
        $model->updateByDto(new PromptDto($request->validated()));
        return new PromptResource($model);
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
        $model = Prompt::query()->findOrFail($id);

        $model->destroyModel();

        return $this->success();
    }

    /**
     * 编辑状态
     *
     * @param $id
     * @param PromptStatusRequest $request
     * @return PromptResource
     */
    public function updateStatus($id, PromptStatusRequest $request)
    {
        /** @var Prompt $model */
        $model = Prompt::query()->where(['id' => $id])->firstOrFail();
        $model = $model->updateStatus($request->input('status'));

        return new PromptResource($model);
    }

    /**
     * 置顶
     *
     * @param $id
     * @return PromptResource
     */
    public function top($id)
    {
        /** @var Prompt $model */
        $maxSort = Prompt::query()->max('sort');
        /** @var Prompt $model */
        $model = Prompt::query()->where(['id' => $id])->firstOrFail();
        return new PromptResource($model->updateSort($maxSort + 1));
    }

    /**
     * 取消置顶
     *
     * @param $id
     * @return PromptResource
     */
    public function cancelTop($id)
    {
        /** @var Prompt $model */
        $model = Prompt::query()->where(['id' => $id])->firstOrFail();
        return new PromptResource($model->updateSort(0));
    }
}
