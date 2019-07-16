<?php

namespace Tests\Libs;

use \Codeception\Test\Unit;
use Tankfairies\Guid\Libs\GuidException;

class GuidExceptionTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testException()
    {
        $this->tester->expectException(
            new GuidException('this is a test'),
            function () {
                throw new GuidException('this is a test');
            }
        );
    }
}
