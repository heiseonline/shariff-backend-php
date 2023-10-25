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
    public function setItem(string $key, string $content): void;

    /**
     * Get cache entry.
     *
     * @param string $key
     *
     * @return string
     */
    public function getItem(string $key): string;

    /**
     * Check if cache entry exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasItem(string $key): bool;
}
