<?php

namespace App\Http\Control\Web;

use App\Http\Resource\PromptCollection;
use App\Model\Prompt;
use Cblink\HyperfExt\BaseController;

class PromptController extends BaseController
{
    /**
     * @return PromptCollection
     */
    public function index()
    {
        $models = Prompt::query()
            ->search([
                'platform' => ['type' => 'eq'],
                'keyword' => [
                    ['type' => 'keyword', 'field' => 'name', 'group' => 'keyword', 'mix' => 'or', 'before' => '%'],
                    ['type' => 'keyword', 'field' => 'desc', 'group' => 'keyword', 'mix' => 'or', 'before' => '%'],
                ],
            ])
            ->leftjoin('prompt_count', 'prompt.id', '=', 'prompt_count.prompt_id')
            ->where(['status' => Prompt::STATUS_ON])
            ->orderByDesc('sort')
            ->orderByDesc('uses')
            ->orderByDesc('created_at')
            ->pageOrAll(['id', 'user_id', 'icon', 'name', 'prompt', 'status', 'sort', 'uses', 'likes', 'created_at', 'desc', 'source', 'type']);

        return new PromptCollection($models);
    }
}
