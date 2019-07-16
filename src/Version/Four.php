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

use Exception;
use Guid\Libs\GuidInterface;

/**
 * Class Four
 *
 * @package Guid\Version
 */
class Four extends AbstractVersion implements VersionInterface
{
    /**
     * @param int $fmt
     * @return string
     * @throws Exception
     */
    public function generate(int $fmt)
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
