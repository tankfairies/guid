<?php

namespace Tests\unit\Version;

use \Codeception\Test\Unit;
use Guid\Libs\GuidInterface;

class AbstractNamespaceTest extends Unit
{
    protected $mock;
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->mock = $this->getMockForAbstractClass('Guid\Version\AbstractNamespace');
        $this->mock->setNamespace('newName');
    }

    protected function _after()
    {
        $this->mock = null;
    }

    public function testGenerate()
    {
        $this->mock->expects($this->once())
            ->method('hash')
            ->will($this->returnValue(md5('newName')));

        $guid = $this->mock->generate(GuidInterface::FMT_STRING);

        $this->assertEquals('34393062-3831-3938-b433-616131356565', $guid);
    }
}
