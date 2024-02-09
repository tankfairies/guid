<?php

namespace Tests\unit\Libs;

use Codeception\Test\Unit;
use UnitTester;
use Tankfairies\Guid\Libs\GuidException;

class GuidExceptionTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testException()
    {
        $this->tester->expectThrowable(
            new GuidException('this is a test'),
            function () {
                throw new GuidException('this is a test');
            }
        );
    }
}
