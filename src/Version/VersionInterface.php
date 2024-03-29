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
 * Interface VersionInterface
 *
 * @package Tankfairies\Guid
 */
interface VersionInterface
{
    /**
     * @param int $fmt
     * @return mixed
     */
    public function generate(int $fmt): mixed;
}
