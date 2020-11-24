<?php

namespace Heise\Shariff;

use Laminas\Cache\Exception as LaminasException;
use Laminas\Cache\Storage\Adapter\FilesystemOptions;
use Laminas\Cache\Storage\ClearExpiredInterface;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Cache\StorageFactory;

/**
 * Implement LaminasCache.
 */
class LaminasCache implements CacheInterface
{
    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @param array $configuration
     *
     * @throws LaminasException\InvalidArgumentException
     * @throws LaminasException\RuntimeException
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
            $options->setCacheDir($configuration['cacheDir'] ?? sys_get_temp_dir());
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
    public function getItem($key): string
    {
        return $this->cache->getItem($key);
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key): bool
    {
        return $this->cache->hasItem($key);
    }
}
