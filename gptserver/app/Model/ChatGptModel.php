<?php

declare (strict_types=1);
namespace App\Model;

use App\Model\Repository\ChatGptModelTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Cblink\ModelLibrary\Hyperf\WhenWithTrait;
use Hyperf\Database\Model\Events\Creating;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;

class ChatGptModel extends Model
{
    use ChatGptModelTrait, PageableTrait, SearchableTrait, WhenWithTrait;

    const STATUS_ON = 1;
    const STATUS_OFF = 2;
    const STATUS_REVIEW = 3;
    const STATUS_VIOLATION = 4;
    const STATUS = [
        self::STATUS_ON => '启用',
        self::STATUS_OFF => '关闭',
        self::STATUS_REVIEW => '待审核',
        self::STATUS_VIOLATION => '违规'
    ];

    const PLATFORM_GPT = 1;
    const PLATFORM_MAGIC = 2;
    const PLATFORM = [
        self::PLATFORM_GPT => 'gpt',
        self::PLATFORM_MAGIC => '魔法书屋',
    ];

    const SOURCE_PLATFORM = 1;
    const SOURCE_MAGIC = 2;
    const SOURCE = [
        self::SOURCE_PLATFORM => ' 平台',
        self::SOURCE_MAGIC => '魔法书屋',
    ];
    const TYPE_DIALOGUE = 1;
    const TYPE_QUESTION = 2;
    const TYPE = [
        self::TYPE_DIALOGUE => '对话',
        self::TYPE_QUESTION => '问答',
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chat_gpt_model';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon', 'user_id', 'name', 'prompt', 'system', 'status', 'sort',
        'platform', 'desc', 'remark', 'source', 'type'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $keyType='string';
    public $incrementing=false;

    /**
     * @param Creating $event
     * @return void
     */
    public function creating(Creating $event)
    {
        $this->id = self::getStringId();
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function getStringId(): string
    {
        $container = ApplicationContext::getContainer();
        $generator = $container->get(IdGeneratorInterface::class);
        return substr(md5((string) $generator->generate()), -16);
    }

    /**
     * 用户
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'user_id');
    }

    /**
     * 统计
     *
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function countData()
    {
        return $this->hasOne(ChatGptModelCount::class, 'chat_gpt_model_id', 'id');
    }
}
