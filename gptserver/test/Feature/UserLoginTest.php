<?php

namespace Feature;

use App\Model\Member;
use HyperfTest\TestCase;

class UserLoginTest extends TestCase
{

    public function testExistsLog()
    {
        Member::doesntHave('oauth')->get(['id', 'nickname', 'mobile']);
    }

}
