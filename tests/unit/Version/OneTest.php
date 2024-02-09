<?php

namespace Tests\unit\Version;

use Codeception\Test\Unit;
use UnitTester;
use Tankfairies\Guid\Libs\GuidInterface;
use Tankfairies\Guid\Version\One;

class OneTest extends Unit
{
    protected One|null $one;

    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    protected function _before()
    {
        $this->one = (new One());
    }

    protected function _after()
    {
        $this->one = null;
    }

    public function testGenerate()
    {
        $guid = $this->one->setSalt('saltsalt')->generate(GuidInterface::FMT_STRING);

        $this->assertTrue(preg_match('/^\w{8}-\w{4}-\w{4}-\w{4}-\w{12}$/i', $guid)!==false);
    }
}
