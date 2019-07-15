<?php

namespace Guid\Version;

/**
 * Class Five
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
