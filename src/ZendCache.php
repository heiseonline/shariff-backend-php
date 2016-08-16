<?php

namespace Heise\Shariff;

use Zend\Cache\Storage\Adapter\FilesystemOptions;
use Zend\Cache\Storage\ClearExpiredInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\StorageFactory;

/**
 * Implement ZendCache.
 */
class ZendCache implements CacheInterface
{
    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @param array $configuration
     *
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
                'options' => $configuration['adapterOptions'],
            ],
        ]);

        $options = $cache->getOptions();
        $options->setNamespace('Shariff');
        $options->setTtl($configuration['ttl']);

        if ($options instanceof FilesystemOptions) {
            $options->setCacheDir(isset($configuration['cacheDir']) ? $configuration['cacheDir'] : sys_get_temp_dir());
        }

        if ($cache instanceof ClearExpiredInterface) {
            $cache->clearExpired();
        }

        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function setItem($key, $content)
    {
        $this->cache->setItem($key, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        return $this->cache->getItem($key);
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key)
    {
        return $this->cache->hasItem($key);
    }
}
