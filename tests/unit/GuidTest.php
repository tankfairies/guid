<?php

namespace Tests\unit;

use \Codeception\Test\Unit;
use Tankfairies\Guid\Guid;
use Tankfairies\Guid\Libs\GuidException;
use Tankfairies\Guid\Libs\GuidInterface;
use Exception;
use UnitTester;

class GuidTest extends Unit
{
    protected Guid $guid;
    protected UnitTester $tester;
    
    protected function _before()
    {
        $this->guid = new Guid();
    }

    protected function _after()
    {
        unset($this->guid);
    }

    // tests
    public function testGenerateV1GuidArray()
    {
        $this->assertTrue(
            $this->isGuidBytes(
                $this->guid->generate(
                    GuidInterface::UUID_TIME,
                    GuidInterface::FMT_BYTE,
                    'demlim'
                )
            )
        );
    }

    public function testGenerateV1GuidString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_TIME,
                    GuidInterface::FMT_STRING,
                    'demlim'
                )
            )
        );
    }
    public function testGenerateV3GuidString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_MD5,
                    GuidInterface::FMT_STRING,
                    'thesalt',
                    'thenamespace'
                )
            )
        );
    }
    public function testGenerateV4GuidString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_RANDOM,
                    GuidInterface::FMT_STRING
                )
            )
        );
    }
    public function testGenerateV5GuidString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_SHA1,
                    GuidInterface::FMT_STRING,
                    'thesalt',
                    'thenamespace'
                )
            )
        );
    }


    public function testGenerateV1GuidBinary()
    {
        $this->assertTrue(
            $this->isGuidBinary(
                $this->guid->generate(
                    GuidInterface::UUID_TIME,
                    GuidInterface::FMT_BINARY,
                    'demlim'
                )
            )
        );
    }
    public function testGenerateV3GuidBinary()
    {
        $this->assertTrue(
            $this->isGuidBinary(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_MD5,
                    GuidInterface::FMT_BINARY,
                    'thesalt',
                    'thenamespace'
                )
            )
        );
    }
    public function testGenerateV4GuidBinary()
    {
        $this->assertTrue(
            $this->isGuidBinary(
                $this->guid->generate(
                    GuidInterface::UUID_RANDOM,
                    GuidInterface::FMT_BINARY
                )
            )
        );
    }
    public function testGenerateV5GuidBinary()
    {
        $this->assertTrue(
            $this->isGuidBinary(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_SHA1,
                    GuidInterface::FMT_BINARY,
                    'thesalt',
                    'thenamespace'
                )
            )
        );
    }


    public function testUnknownType()
    {
        $this->tester->expectThrowable(
            new GuidException('Unknown version'),
            function () {
                $this->guid->generate(99);
            }
        );
    }

    public function testInvalidType()
    {
        $this->tester->expectThrowable(
            new Exception('Unknown error'),
            function () {
                $this->guid->generate(
                    GuidInterface::UUID_NAME_SHA1,
                    GuidInterface::FMT_FIELD,
                    'newsalt'
                );
            }
        );
    }

    public function testV1SaltNotSet()
    {
        $this->tester->expectThrowable(
            new GuidException('Salt not set'),
            function () {
                $this->guid->generate(
                    GuidInterface::UUID_TIME,
                    GuidInterface::FMT_STRING
                );
            }
        );
    }


    public function testGenerateV3GuidNamespaceByte()
    {
        $this->assertTrue(
            $this->isGuidBytes(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_MD5,
                    GuidInterface::FMT_BYTE,
                    'demlim',
                    'demo'
                )
            )
        );
    }
    public function testGenerateV5GuidNamespaceByte()
    {
        $this->assertTrue(
            $this->isGuidBytes(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_SHA1,
                    GuidInterface::FMT_BYTE,
                    'demlim',
                    'demo'
                )
            )
        );
    }
    public function testGenerateV3GuidNamespaceString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_MD5,
                    GuidInterface::FMT_STRING,
                    'demlim',
                    'demo'
                )
            )
        );
    }
    public function testGenerateV5GuidNamespaceString()
    {
        $this->assertTrue(
            $this->isGuidString(
                $this->guid->generate(
                    GuidInterface::UUID_NAME_SHA1,
                    GuidInterface::FMT_STRING,
                    'demlim',
                    'demo'
                )
            )
        );
    }

    protected function isGuidBytes($guid): bool
    {
        return is_array($guid) && count($guid) == 16 && array_sum($guid) > 0;
    }

    protected function isGuidString($guid): bool
    {
        return is_string($guid) && mb_strlen($guid) == 36;
    }

    protected function isGuidBinary($guid): bool
    {
        return mb_strlen(bin2hex($guid)) == 32;
    }
}
