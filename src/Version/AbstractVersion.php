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
 * Class AbstractVersion
 * @package Guid\Version
 */
abstract class AbstractVersion
{
    /* UUID versions */
    const UUID_TIME = 1;       /* Time based UUID */
    const UUID_NAME_MD5 = 3;   /* Name based (MD5) UUID */
    const UUID_RANDOM = 4;     /* Random UUID */
    const UUID_NAME_SHA1 = 5;  /* Name based (SHA1) UUID */

    /* UUID formats */
    const FMT_FIELD = 100;
    const FMT_STRING = 101;
    const FMT_BINARY = 102;
    const FMT_BYTE = 16;

    /* Field UUID representation */
    protected $uuidField = [
        'time_low' => 0,      /* 32-bit */
        'time_mid' => 0,      /* 16-bit */
        'time_hi' => 0,       /* 16-bit */
        'clock_seq_hi' => 0,  /*  8-bit */
        'clock_seq_low' => 0, /*  8-bit */
        'node' => []          /* 48-bit */
    ];

    protected $convert = [
        GuidInterface::FMT_FIELD => [
            GuidInterface::FMT_BYTE => 'field2byte',
            GuidInterface::FMT_STRING => 'field2string',
            GuidInterface::FMT_BINARY => 'field2binary'
        ],
        GuidInterface::FMT_BYTE => [
            GuidInterface::FMT_FIELD => 'byte2field',
            GuidInterface::FMT_STRING => 'byte2string',
            GuidInterface::FMT_BINARY => 'byte2binary'
        ],
        GuidInterface::FMT_STRING => [
            GuidInterface::FMT_FIELD => 'string2field',
        ],
    ];

    protected $salt = '';
    protected $namespace = '';

    /**
     * Set the namespace for v3 and v5
     *
     * @param $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Sets the salt for v1, v3 and v5
     *
     * @param $salt
     * @return $this
     * @throws GuidException
     */
    public function setSalt($salt)
    {
        $size = mb_strlen($salt);
        if ($size < 6 && $size != 0) {
            throw new GuidException('Salt needs to be at least 6 characters long');
        }
        $this->salt = $salt;
        return $this;
    }

    /**
     * Swap byte order of a 32-bit number
     *
     * @param $x
     * @return int
     */
    protected function swap32($x)
    {
        return (($x & 0x000000ff) << 24) | (($x & 0x0000ff00) << 8) | (($x & 0x00ff0000) >> 8) | (($x & 0xff000000) >> 24);
    }

    /**
     * Swap byte order of a 16-bit number
     *
     * @param $x
     * @return int
     */
    protected function swap16($x)
    {
        return (($x & 0x00ff) << 8) | (($x & 0xff00) >> 8);
    }

    /**
     * Assumes correct byte order
     *
     * @param $src
     * @return mixed
     */
    protected function field2byte($src)
    {
        $uuid[0] = ($src['time_low'] & 0xff000000) >> 24;
        $uuid[1] = ($src['time_low'] & 0x00ff0000) >> 16;
        $uuid[2] = ($src['time_low'] & 0x0000ff00) >> 8;
        $uuid[3] = ($src['time_low'] & 0x000000ff);
        $uuid[4] = ($src['time_mid'] & 0xff00) >> 8;
        $uuid[5] = ($src['time_mid'] & 0x00ff);
        $uuid[6] = ($src['time_hi'] & 0xff00) >> 8;
        $uuid[7] = ($src['time_hi'] & 0x00ff);
        $uuid[8] = $src['clock_seq_hi'];
        $uuid[9] = $src['clock_seq_low'];

        for ($i = 0; $i < 6; $i++) {
            $uuid[10 + $i] = $src['node'][$i];
        }

        return ($uuid);
    }

    /**
     * @param $src
     * @return string
     */
    protected function field2string($src)
    {
        $str = sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            ($src['time_low']),
            ($src['time_mid']),
            ($src['time_hi']),
            $src['clock_seq_hi'],
            $src['clock_seq_low'],
            $src['node'][0],
            $src['node'][1],
            $src['node'][2],
            $src['node'][3],
            $src['node'][4],
            $src['node'][5]
        );

        return ($str);
    }

    /**
     * @param $src
     * @return false|string
     */
    protected function field2binary($src)
    {
        $byte = $this->field2byte($src);
        return $this->byte2binary($byte);
    }

    /**
     * @param $uuid
     * @return array
     */
    protected function byte2field($uuid)
    {
        $field = $this->uuidField;
        $field['time_low'] = ($uuid[0] << 24) | ($uuid[1] << 16) | ($uuid[2] << 8) | $uuid[3];
        $field['time_mid'] = ($uuid[4] << 8) | $uuid[5];
        $field['time_hi'] = ($uuid[6] << 8) | $uuid[7];
        $field['clock_seq_hi'] = $uuid[8];
        $field['clock_seq_low'] = $uuid[9];

        for ($i = 0; $i < 6; $i++) {
            $field['node'][$i] = $uuid[10 + $i];
        }

        return ($field);
    }

    /**
     * @param $src
     * @return false|string
     */
    protected function byte2binary($src)
    {
        $raw = pack(
            'C16',
            $src[0],
            $src[1],
            $src[2],
            $src[3],
            $src[4],
            $src[5],
            $src[6],
            $src[7],
            $src[8],
            $src[9],
            $src[10],
            $src[11],
            $src[12],
            $src[13],
            $src[14],
            $src[15]
        );
        return ($raw);
    }

    /**
     * @param $src
     * @return array
     */
    protected function string2field($src)
    {
        $parts = sscanf($src, '%x-%x-%x-%x-%02x%02x%02x%02x%02x%02x');
        $field = $this->uuidField;
        $field['time_low'] = ($parts[0]);
        $field['time_mid'] = ($parts[1]);
        $field['time_hi'] = ($parts[2]);
        $field['clock_seq_hi'] = ($parts[3] & 0xff00) >> 8;
        $field['clock_seq_low'] = $parts[3] & 0x00ff;

        for ($i = 0; $i < 6; $i++) {
            $field['node'][$i] = $parts[4 + $i];
        }

        return ($field);
    }
}
