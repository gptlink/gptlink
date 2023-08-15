<?php

use HyperfTest\TestDto\Docs;

define("BASE_PATH", dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

(new Docs(require BASE_PATH.'/test/TestDto/config.php'))->make();
