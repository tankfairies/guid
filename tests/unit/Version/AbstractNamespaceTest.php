<?php

namespace Tests\unit\Version;

use Codeception\Test\Unit;
use UnitTester;
use Tankfairies\Guid\Libs\GuidInterface;
use Tankfairies\Guid\Version\AbstractNamespace;

class AbstractNamespaceTest extends Unit
{
    protected $mock;
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    protected function _before()
    {
        $this->mock = new class extends AbstractNamespace {
            // Just a sample public function that returns this anonymous instance
            public function hash(string $value): string
            {
                return md5('newName');
            }
        };

        $this->mock->setNamespace('newName');
    }

    protected function _after()
    {
        $this->mock = null;
    }

    public function testGenerate()
    {
        $guid = $this->mock->generate(GuidInterface::FMT_STRING);

        $this->assertEquals('34393062-3831-3938-b433-616131356565', $guid);
    }
}
