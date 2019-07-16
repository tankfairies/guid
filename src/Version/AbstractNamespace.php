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

use Guid\Libs\GuidInterface;

/**
 * Class AbstractNamespace
 * @package Version
 */
abstract class AbstractNamespace extends AbstractVersion implements VersionInterface
{

    /**
     * @param int $fmt
     * @return string
     */
    public function generate(int $fmt)
    {
        $field = $this->string2field($this->namespace);

        /* Swap byte order to keep it in big endian on all platforms */
        $field['time_low'] = $this->swap32($field['time_low']);
        $field['time_mid'] = $this->swap16($field['time_mid']);
        $field['time_hi'] = $this->swap16($field['time_hi']);

        /* Convert the namespace to binary and concatenate salt */
        $raw = $this->field2binary($field).$this->salt;

        /* Hash the namespace and salt and convert to a byte array */
        $val = $this->hash($raw);
        $tmp = unpack('C16', $val);

        $byte = [];
        foreach (array_keys($tmp) as $key) {
            $byte[$key - 1] = $tmp[$key];
        }

        /* Convert byte array to a field array */
        $field = $this->byte2field($byte);

        $field['time_low'] = $this->swap32($field['time_low']);
        $field['time_mid'] = $this->swap16($field['time_mid']);
        $field['time_hi'] = $this->swap16($field['time_hi']);

        /* Apply version and constants */
        $field['clock_seq_hi'] &= 0x3f;
        $field['clock_seq_hi'] |= (1 << 7);
        $field['time_hi'] &= 0x0fff;
        $field['time_hi'] |= (3 << 12);

        $conv = $this->convert[GuidInterface::FMT_FIELD][$fmt];

        return $this->$conv($field);
    }

    /**
     * @param string $value
     * @return string
     */
    abstract protected function hash(string $value);
}
