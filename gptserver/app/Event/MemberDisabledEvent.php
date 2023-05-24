<?php

namespace App\Event;


use App\Http\Dto\MemberDisabledRcordDto;

class MemberDisabledEvent
{
    /**
     * @var MemberDisabledRcordDto
     */
    public $dto;


    public function __construct(MemberDisabledRcordDto $dto)
    {
        $this->dto = $dto;
    }
}
