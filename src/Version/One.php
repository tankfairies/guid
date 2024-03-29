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

use Tankfairies\Guid\Libs\GuidException;
use Tankfairies\Guid\Libs\GuidInterface;

/**
 * Class One
 *
 * Represents version 1 GUID (Globally Unique Identifier)
 *
 * @package Tankfairies\Guid
 */
class One extends AbstractVersion implements VersionInterface
{

    /**
     * Generates a GUID (Globally Unique Identifier).
     *
     * @param int $fmt The format of the generated GUID.
     * @return mixed The generated GUID according to the specified format.
     *
     * @throws GuidException If the salt is not set.
     */
    public function generate(int $fmt): mixed
    {
        if ($this->salt == '') {
            throw new GuidException('Salt not set');
        }

        /*
         * 0x01b21dd213814000 is the number of 100-ns intervals between the
         * UUID epoch 1582-10-15 00:00:00 and the Unix epoch 1970-01-01 00:00:00.
         */
        $tp = gettimeofday();
        $time = ($tp['sec'] * 10000000) + ($tp['usec'] * 10) + 0x01B21DD213814000;

        $this->uuidField['time_low'] = $time & 0xffffffff;

        /* Work around PHP 32-bit bit-operation limits */
        $high = intval($time / 0xffffffff);
        $this->uuidField['time_mid'] = $high & 0xffff;
        $this->uuidField['time_hi'] = (($high >> 16) & 0xfff) | (GuidInterface::UUID_TIME << 12);

        /*
         * We don't support saved state information and generate
         * a random clock sequence each time.
         */
        $this->uuidField['clock_seq_hi'] = 0x80 | random_int(0, 64);
        $this->uuidField['clock_seq_low'] = random_int(0, 255);

        /*
         * Node should be set to the 48-bit IEEE node identifier, but
         * we leave it for the user to supply the node.
         */
        for ($i = 0; $i < 6; $i++) {
            $this->uuidField['node'][$i] = ord(substr($this->salt, $i, 1));
        }

        $conv = $this->convert[GuidInterface::FMT_FIELD][$fmt];

        return $this->$conv($this->uuidField);
    }
}
