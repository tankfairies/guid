<?php

/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/guid
 */

namespace Guid;

use Guid\Libs\GuidException;
use Guid\Libs\GuidInterface;
use Guid\Version\Five;
use Guid\Version\Four;
use Guid\Version\One;
use Guid\Version\Three;
use Exception;

/**
 * Class Guid
 *
 * Generates a Guid.
 * GUID (RFC4122) Generator
 * http://tools.ietf.org/html/rfc4122
 *
 * Implements version 1, 3, 4 and 5
 *
 * Version-1 UUIDs are generated from a time and a node id (usually the MAC address);
 * version-2 UUIDs are generated from an identifier (usually a group or user id), time, and a node id;
 * version-3 produce deterministic UUIDs generated by md5 hashing a namespace identifier and name;
 * version-4 UUIDs are generated using a random or pseudo-random number;
 * version-5 produce deterministic UUIDs generated by sha1 hashing a namespace identifier and name;
 *
 * @package Guid
 */
class Guid
{
    /**
     * Public API, generate a UUID of 'type' in format 'fmt' for
     * the given namespace 'ns' and node 'node'
     *
     * @param int $type
     * @param int $fmt
     * @param string $salt
     * @param string $namespace
     * @return string
     * @throws GuidException
     */
    public function generate(int $type, int $fmt = GuidInterface::FMT_BYTE, $salt = '', $namespace = '')
    {
        try {
            switch ($type) {
                case GuidInterface::UUID_TIME:
                    $version = (new One())->setSalt($salt);
                    break;
                case GuidInterface::UUID_NAME_MD5:
                    $version = (new Three())->setNamespace($namespace)->setSalt($salt);
                    break;
                case GuidInterface::UUID_RANDOM:
                    $version = new Four();
                    break;
                case GuidInterface::UUID_NAME_SHA1:
                    $version = (new Five())->setNamespace($namespace)->setSalt($salt);
                    break;
                default:
                    throw new GuidException('Unknown version');
            }

            return $version->generate($fmt);
        } catch (GuidException $guidException) {
            throw new GuidException($guidException->getMessage());
        } catch (Exception $exception) {
            throw new GuidException('Unknown error');
        }
    }
}
