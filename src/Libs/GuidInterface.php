<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/guid
 */

namespace Tankfairies\Guid\Libs;

/**
 * Interface GuidInterface
 *
 * @package Guid
 */
interface GuidInterface
{
    /* UUID versions */
    public const UUID_TIME = 1;      /* Time based UUID */
    public const UUID_NAME_MD5 = 3;  /* Name based (MD5) UUID */
    public const UUID_RANDOM = 4;    /* Random UUID */
    public const UUID_NAME_SHA1 = 5; /* Name based (SHA1) UUID */

    /* UUID formats */
    public const FMT_FIELD = 100;
    public const FMT_STRING = 101;
    public const FMT_BINARY = 102;
    public const FMT_BYTE = 16;
}
