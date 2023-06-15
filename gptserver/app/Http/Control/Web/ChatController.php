<?php

namespace App\Http\Control\Web;

use App\Base\Consts\ModelConst;
use App\Exception\ErrCode;
use App\Exception\LogicException;
use App\Http\Dto\ChatDto;
use App\Http\Dto\Config\KeywordDto;
use App\Http\Request\ChatRequest;
use App\Http\Service\ChatGPTService;
use App\Job\GptModelUsesJob;
use App\Model\ChatGptModel;
use App\Model\Config;
use App\Model\MemberPackage;
use Cblink\HyperfExt\BaseController;
use Hyperf\Di\Annotation\Inject;

class ChatController extends BaseController
{
    #[Inject]
    protected ChatGPTService $service;

    /**
     * 实时返回
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException|\Throwable
     */
    public function process(ChatRequest $request)
    {
        // 查询是否允许访问
        throw_unless(
            MemberPackage::existsPackage($userId = auth()->id()),
            LogicException::class,
            ErrCode::MEMBER_INSUFFICIENT_BALANCE
        );

        // 关键词检测
        /* @var KeywordDto $keywordDto */
        $keywordDto = Config::toDto(Config::KEYWORD);
        if ($keywordDto->enable) {

            $keywords = json_decode($keywordDto->keywords, true);

            $pattern = "/".implode("|", $keywords)."/i";

            preg_match_all($pattern, $request->input('message'), $matches);

            throw_if($matches[0], LogicException::class, ErrCode::CHAT_CONTAINS_PROHIBITED_WORDS);
        }

        $system = null;

        if ($request->input('model_id') && $model = ChatGptModel::query()->find($request->input('model_id'))) {
            $system = $model->system;
            asyncQueue(new GptModelUsesJob($model->id));
        }

        $gptModel = config('openai.chat.model', ModelConst::GPT_35_TURBO);
        $gptModel = array_key_exists($gptModel, ModelConst::MODEL) ? $gptModel : ModelConst::GPT_35_TURBO;

        $chatDto = new ChatDto(array_merge($request->inputs(['message', 'last_id']), [
            'model' => $gptModel,
            'system' => $system,
            'stream' => true,
            'format_after' => ',',
        ]));

        // 数据量输出
        $this->service->chatProcess($userId, $chatDto);

        return $this->success();
    }
}
