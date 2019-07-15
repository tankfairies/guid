<?php

namespace Guid\Libs;

/**
 * Interface GuidInterface
 * @package Guid
 */
interface GuidInterface
{
    /* UUID versions */
    const UUID_TIME = 1;      /* Time based UUID */
    const UUID_NAME_MD5 = 3;  /* Name based (MD5) UUID */
    const UUID_RANDOM = 4;    /* Random UUID */
    const UUID_NAME_SHA1 = 5; /* Name based (SHA1) UUID */

    /* UUID formats */
    const FMT_FIELD = 100;
    const FMT_STRING = 101;
    const FMT_BINARY = 102;
    const FMT_BYTE = 16;
}
