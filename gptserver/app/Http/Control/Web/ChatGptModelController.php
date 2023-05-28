<?php

namespace App\Http\Control\Web;

use App\Http\Request\Web\ChatGptModelIndexRequest;
use App\Http\Resource\ChatGptModelCollection;
use App\Model\ChatGptModel;
use Cblink\HyperfExt\BaseController;

class ChatGptModelController extends BaseController
{
    /**
     * @return ChatGptModelCollection
     */
    public function index()
    {
		$models = ChatGptModel::query()
			->search([
				'platform' => ['type' => 'eq'],
				'keyword' => [
					['type' => 'keyword', 'field' => 'name', 'group' => 'keyword', 'mix' =>'or', 'before'=> '%'],
					['type' => 'keyword', 'field' => 'desc', 'group' => 'keyword', 'mix' =>'or', 'before'=> '%'],
				]
			])
			->leftjoin('chat_gpt_model_count', 'chat_gpt_model.id', '=', 'chat_gpt_model_count.chat_gpt_model_id')
            ->where(['status' => ChatGptModel::STATUS_ON])
            ->orderByDesc('sort')
            ->orderByDesc('uses')
            ->orderByDesc('created_at')
			->pageOrAll(['id', 'user_id', 'icon', 'name', 'prompt', 'status', 'sort', 'uses', 'likes','created_at', 'desc', 'source', 'type']);

		return new ChatGptModelCollection($models);
    }
}
