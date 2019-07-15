<?php

namespace Tests\unit\Version;

use \Codeception\Test\Unit;
use Guid\Libs\GuidInterface;
use Guid\Version\Four;

class FourTest extends Unit
{
    protected $four;

    /**
     * @var \UnitTester
     */
    protected $tester;

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
