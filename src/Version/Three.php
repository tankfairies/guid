<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/guid
 */

namespace Tankfairies\Guid\Version;

/**
 * Class Three
 *
 * Represents version 4 GUID (Globally Unique Identifier)
 *
 * @package Tankfairies\Guid
 */
class Three extends AbstractNamespace
{
    /**
     * Hashes the given value using the MD5 algorithm.
     *
     * @param string $value The value to be hashed.
     *
     * @return string The hashed value.
     */
    protected function hash(string $value): string
    {
        return md5($value, true);
    }
}
