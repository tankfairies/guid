<?php


namespace Guid\Version;

/**
 * Interface VersionInterface
 * @package Version
 */
interface VersionInterface
{
    /**
     * @param int $fmt
     * @return mixed
     */
    public function generate(int $fmt);
}
