<?php

namespace App\Model\Repository;

use App\Event\SalesmanOrderCreateEvent;
use App\Http\Dto\SalesmanOrderDto;
use App\Model\SalesmanOrder;

trait SalesmanOrderTrait
{
    /**
     * @param SalesmanOrderDto $dto
     * @return SalesmanOrder
     */
    public static function createByDto(SalesmanOrderDto $dto)
    {
        /* @var SalesmanOrder $salesmanOrder */
        $salesmanOrder = SalesmanOrder::query()->create($dto->toModel());

        event(new SalesmanOrderCreateEvent($salesmanOrder));

        return $salesmanOrder;
    }
}
