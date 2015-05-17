<?php

namespace Heise\Shariff;

use Zend\Cache\Storage\Adapter\FilesystemOptions;
use Zend\Cache\Storage\ClearExpiredInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;

/**
 * Implement ZendCache
 *
 * @package Heise\Shariff
 */
class ZendCache implements CacheInterface
{

    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @param array $configuration
     * @throws \Zend\Cache\Exception\InvalidArgumentException
     * @throws \Zend\Cache\Exception\RuntimeException
     */
    public function __construct(array $configuration)
    {

        if (!isset($configuration['adapter'])) {
            $configuration['adapter'] = 'Filesystem';
        }

        if (!isset($configuration['adapterOptions'])) {
            $configuration['adapterOptions'] = [];
        }

        $cache = StorageFactory::factory([
            'adapter' => [
                'name' => $configuration['adapter'],
                'options' => $configuration['adapterOptions']
            ]
        ]);

        $options = $cache->getOptions();
        $options->setNamespace('Shariff');
        $options->setTtl($configuration['ttl']);

        if ($options instanceof FilesystemOptions) {
            $options->setCacheDir(isset($configuration['cacheDir']) ? $configuration['cacheDir'] : sys_get_temp_dir());
        }

        if ($cache instanceof ClearExpiredInterface) {
            if (function_exists('register_postsend_function')) {
                // for hhvm installations: executing after response / session close
                register_postsend_function(function () use ($cache) {
                    $cache->clearExpired();
                });
            } else {
                // default
                $cache->clearExpired();
            }
        }

        $this->cache = $cache;
    }

    /**
     * Set cache entry
     *
     * @param string $key
     * @param string $content
     * @return void
     */
    public function setItem($key, $content)
    {
        $this->cache->setItem($key, $content);
    }

    /**
     * Get cache entry
     *
     * @param string $key
     * @return string
     */
    public function getItem($key)
    {
        return $this->cache->getItem($key);
    }

    /**
     * Check if cache entry exists
     *
     * @param string $key
     * @return bool
     */
    public function hasItem($key)
    {
        return $this->cache->hasItem($key);
    }
}
