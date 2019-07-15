<?php

namespace Tests\unit\Version;

use \Codeception\Test\Unit;
use Guid\Libs\GuidInterface;
use Guid\Version\One;

class OneTest extends Unit
{
    protected $one;

    /**
     * @var \UnitTester
     */
    protected $tester;

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

        $this->assertTrue(preg_match('/^\w{8}\-\w{4}\-\w{4}\-\w{4}\-\w{12}$/i', $guid)!==false);
    }
}
