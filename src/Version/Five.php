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
 * Class Five
 *
 * Provides functionality for hashing values using the SHA1 algorithm,
 * and it represents a version 5 GUID.
 *
 * @package Tankfairies\Guid
 */
class Five extends AbstractNamespace
{
    /**
     * Hashes the given value using the SHA1 algorithm.
     *
     * @param string $value The value to be hashed.
     * @return string The hashed value as a string.
     */
    protected function hash(string $value): string
    {
        return sha1($value, true);
    }
}
