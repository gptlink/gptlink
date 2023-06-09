<?php

namespace App\Base\Consts;

class ModelConst
{

    public const GPT_35_TURBO = 'gpt-3.5-turbo';
    public const GPT_40 = 'gpt-4';
    public const GPT_40_32K = 'gpt-4-32k';


    const MODEL = [
        self::GPT_35_TURBO => '3.5',
        self::GPT_40 => '4.0',
        self::GPT_40_32K => '4.0 32k',
    ];
}
