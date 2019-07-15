<?php

namespace Guid\Version;

/**
 * Class Three
 * @package Guid\Version
 */
class Three extends AbstractNamespace
{
    /**
     * @param string $value
     * @return string
     */
    protected function hash(string $value)
    {
        return md5($value, true);
    }
}
