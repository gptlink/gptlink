<?php

namespace App\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerInterface;

#[Command]
class CreateCdkCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('config:test');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('测试连通性');
    }

    public function handle()
    {
        try {
            Db::connection('default')->statement('show tables');
            $this->line('mysql successfully!');
        } catch (\Exception $exception) {
            $this->line('mysql fail: ' . $exception->getMessage());
        }

        try {
            redis()->get('test');
            $this->line('redis successfully!');
        } catch (\Exception $exception) {
            $this->line('redis fail: ' . $exception->getMessage());
        }
    }
}
