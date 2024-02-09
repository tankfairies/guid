<?php

namespace Tests\unit\Version;

use Codeception\Test\Unit;
use UnitTester;
use Tankfairies\Guid\Libs\GuidInterface;
use Tankfairies\Guid\Version\Four;

class FourTest extends Unit
{
    protected Four|null $four;

    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    protected function _before()
    {
        $this->four = (new Four());
    }

    protected function _after()
    {
        $this->four = null;
    }

    public function testGenerate()
    {
        $guid = $this->four->generate(GuidInterface::FMT_STRING);

        $this->assertTrue(preg_match('/^\w{8}\-\w{4}\-\w{4}\-\w{4}\-\w{12}$/i', $guid)!==false);
    }
}
