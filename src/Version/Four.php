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

use Random\RandomException;
use Tankfairies\Guid\Libs\GuidInterface;

/**
 * Class Four
 *
 * Represents version 4 GUID (Globally Unique Identifier)
 *
 * @package Tankfairies\Guid
 */
class Four extends AbstractVersion implements VersionInterface
{
    /**
     * Generates a UUID based on the given format.
     *
     * @param int $fmt The format of the UUID to generate. Possible values are defined in GuidInterface::FMT_FIELD.
     * @return string The generated UUID.
     *
     * @throws RandomException
     */
    public function generate(int $fmt): string
    {
        $uuid = $this->uuidField;

        $uuid['time_hi'] = (4 << 12) | (random_int(0, 0x1000));
        $uuid['clock_seq_hi'] = (1 << 7) | random_int(0, 128);
        $uuid['time_low'] = random_int(0, 0xffff) + (random_int(0, 0xffff) << 16);
        $uuid['time_mid'] = random_int(0, 0xffff);
        $uuid['clock_seq_low'] = random_int(0, 255);

        for ($i = 0; $i < 6; $i++) {
            $uuid['node'][$i] = random_int(0, 255);
        }

        $conv = $this->convert[GuidInterface::FMT_FIELD][$fmt];

        return $this->$conv($uuid);
    }
}
