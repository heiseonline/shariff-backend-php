<?php

namespace Heise\Shariff;

/**
 * Generic Cache Interface.
 *
 * @author Markus Klein <markus.klein@typo3.org>
 */
interface CacheInterface
{
    /**
     * Set cache entry.
     *
     * @param string $key
     * @param string $content
     */
    public function setItem($key, $content);

    /**
     * Get cache entry.
     *
     * @param string $key
     *
     * @return string
     */
    public function getItem($key);

    /**
     * Check if cache entry exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasItem($key);
}
