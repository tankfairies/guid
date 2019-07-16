<?php

namespace Tests\unit\Version;

use \Codeception\Test\Unit;
use Guid\Libs\GuidException;
use ReflectionProperty;

class AbstractVersionTest extends Unit
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

    public function testSetNamespace()
    {
        $mock = $this->getMockForAbstractClass('Guid\Version\AbstractVersion');
        $mock->setNamespace('newName');

        $reflection = new ReflectionProperty($mock, 'namespace');
        $reflection->setAccessible(true);
        $this->assertEquals('newName', $reflection->getValue($mock));
    }

    public function testSetSalt()
    {
        $mock = $this->getMockForAbstractClass('Guid\Version\AbstractVersion');
        $mock->setSalt('newsalt');

        $reflection = new ReflectionProperty($mock, 'salt');
        $reflection->setAccessible(true);
        $this->assertEquals('newsalt', $reflection->getValue($mock));
    }

    public function testSetSaltInvalid()
    {
        $this->tester->expectException(
            new GuidException('Salt needs to be at least 6 characters long'),
            function () {
                $mock = $this->getMockForAbstractClass('Guid\Version\AbstractVersion');
                $mock->setSalt('123');
                //$this->guid->generate(GuidInterface::UUID_TIME, GuidInterface::FMT_STRING);
            }
        );
        //$mock = $this->getMockForAbstractClass('Guid\Version\AbstractVersion');
        //$mock->setSalt('newsalt');

        ///$reflection = new ReflectionProperty($mock, 'salt');
        //$reflection->setAccessible(true);
        //$this->assertEquals('new', $reflection->getValue($mock));
    }
}
