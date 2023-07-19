<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\PromptTrait;
use Cblink\ModelLibrary\Hyperf\PageableTrait;
use Cblink\ModelLibrary\Hyperf\SearchableTrait;
use Cblink\ModelLibrary\Hyperf\WhenWithTrait;
use Hyperf\Database\Model\Events\Creating;
use Hyperf\DbConnection\Model\Model;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;

class Prompt extends Model
{
    use PromptTrait, PageableTrait, SearchableTrait, WhenWithTrait;

    public const STATUS_ON = 1;

    public const STATUS_OFF = 2;

    public const STATUS = [
        self::STATUS_ON => '启用',
        self::STATUS_OFF => '关闭',
    ];

    public const PLATFORM_GPT = 1;

    public const PLATFORM = [
        self::PLATFORM_GPT => 'gpt',
    ];

    public const SOURCE_PLATFORM = 1;

    public const SOURCE = [
        self::SOURCE_PLATFORM => ' 平台',
    ];

    public const TYPE_DIALOGUE = 1;

    public const TYPE = [
        self::TYPE_DIALOGUE => '对话',
    ];

    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prompt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icon', 'user_id', 'name', 'prompt', 'system', 'status', 'sort',
        'platform', 'desc', 'remark', 'source', 'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $keyType = 'string';

    /**
     * @param Creating $event
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
        return $this->hasOne(PromptCount::class, 'prompt_id', 'id');
    }
}
