<?php

namespace Tests;

use \Codeception\Test\Unit;
use Guid\Guid;
use Guid\Libs\GuidException;
use Guid\Libs\GuidInterface;
use Exception;

class GuidTest extends Unit
{
    protected $guid;

    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->guid = new Guid();
    }

    protected function _after()
    {
        $this->guid = null;
    }

    // tests
    public function testGenerateV1GuidArray()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_TIME, GuidInterface::FMT_BYTE, 'demlim')));
    }
    public function testGenerateV3GuidArray()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_NAME_MD5)));
    }
    public function testGenerateV4GuidArray()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_RANDOM)));
    }
    public function testGenerateV5GuidArray()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_NAME_SHA1)));
    }


    public function testGenerateV1GuidString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_TIME, GuidInterface::FMT_STRING, 'demlim')));
    }
    public function testGenerateV3GuidString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_NAME_MD5, GuidInterface::FMT_STRING)));
    }
    public function testGenerateV4GuidString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_RANDOM, GuidInterface::FMT_STRING)));
    }
    public function testGenerateV5GuidString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_NAME_SHA1, GuidInterface::FMT_STRING)));
    }


    public function testGenerateV1GuidBinary()
    {
        $this->assertTrue($this->isGuidBinary($this->guid->generate(GuidInterface::UUID_TIME, GuidInterface::FMT_BINARY, 'demlim')));
    }
    public function testGenerateV3GuidBinary()
    {
        $this->assertTrue($this->isGuidBinary($this->guid->generate(GuidInterface::UUID_NAME_MD5, GuidInterface::FMT_BINARY)));
    }
    public function testGenerateV4GuidBinary()
    {
        $this->assertTrue($this->isGuidBinary($this->guid->generate(GuidInterface::UUID_RANDOM, GuidInterface::FMT_BINARY)));
    }
    public function testGenerateV5GuidBinary()
    {
        $this->assertTrue($this->isGuidBinary($this->guid->generate(GuidInterface::UUID_NAME_SHA1, GuidInterface::FMT_BINARY)));
    }


    public function testUnknownType()
    {
        $this->tester->expectException(
            new GuidException('Unknown version'),
            function () {
                $this->guid->generate(99);
            }
        );
    }

    public function testInvalidType()
    {
        $this->tester->expectException(
            new Exception('Unknown error'),
            function () {
                $this->guid->generate(GuidInterface::UUID_NAME_SHA1, GuidInterface::FMT_FIELD);
            }
        );
    }

    public function testV1SaltNotSet()
    {
        $this->tester->expectException(
            new GuidException('Salt not set'),
            function () {
                $this->guid->generate(GuidInterface::UUID_TIME, GuidInterface::FMT_STRING);
            }
        );
    }


    public function testGenerateV3GuidNamespaceByte()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_NAME_MD5, GuidInterface::FMT_BYTE, 'demlim', 'demo')));
    }
    public function testGenerateV5GuidNamespaceByte()
    {
        $this->assertTrue($this->isGuidBytes($this->guid->generate(GuidInterface::UUID_NAME_SHA1, GuidInterface::FMT_BYTE, 'demlim', 'demo')));
    }
    public function testGenerateV3GuidNamespaceString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_NAME_MD5, GuidInterface::FMT_STRING, 'demlim', 'demo')));
    }
    public function testGenerateV5GuidNamespaceString()
    {
        $this->assertTrue($this->isGuidString($this->guid->generate(GuidInterface::UUID_NAME_SHA1, GuidInterface::FMT_STRING, 'demlim', 'demo')));
    }



    protected function isGuidBytes($guid)
    {
        return is_array($guid) && count($guid) == 16 && array_sum($guid) > 0;
    }

    protected function isGuidString($guid)
    {
        return is_string($guid) && mb_strlen($guid) == 36;
    }

    protected function isGuidBinary($guid)
    {
        return mb_strlen(bin2hex($guid)) == 32;
    }
}
