<?php

namespace Feature;

use Gioni06\Gpt3Tokenizer\Gpt3Tokenizer;
use Gioni06\Gpt3Tokenizer\Gpt3TokenizerConfig;
use HyperfTest\TestCase;

class TokenTest extends TestCase
{

    public function testCalcTokens()
    {
        $text = "你好呀，哈哈哈哈";

        $config = new Gpt3TokenizerConfig();
        $tokenizer = new Gpt3Tokenizer($config);
        $tokens = $tokenizer->encode($text);

        $this->assertEquals(count($tokens), 21);
    }
}
