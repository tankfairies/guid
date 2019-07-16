<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/guid
 */

namespace Guid\Version;

/**
 * Class Five
 *
 * @package Guid\Version
 */
class Five extends AbstractNamespace
{
    /**
     * @param string $value
     * @return string
     */
    protected function hash(string $value)
    {
        return sha1($value, true);
    }
}
