<?php declare(strict_types=1);

namespace Heise\Shariff;

use GuzzleHttp\Client;
use Heise\Shariff\Backend\BackendManager;
use Heise\Shariff\Backend\ServiceFactory;
use InvalidArgumentException;
use JsonException;
use Psr\Log\LoggerInterface;

/**
 * Class Backend.
 */
class Backend
{
    protected BackendManager $backendManager;

    /**
     * @param array $config
     *
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function __construct(array $config)
    {
        $domains = $config['domains'] ?? [];

        // stay compatible to old configs
        if (isset($config['domain'])) {
            $domains[] = $config['domain'];
        }

        $clientOptions = [];

        if (isset($config['client'])) {
            $clientOptions = $config['client'];
        }
        $client = new Client($clientOptions);
        $baseCacheKey = md5(json_encode($config, JSON_THROW_ON_ERROR));

        $cacheClass = $config['cacheClass'] ?? LaminasCache::class;

        if (!is_a($cacheClass, CacheInterface::class, true)) {
            throw new InvalidArgumentException(
                sprintf('Cache class "%s" must implement %s.', $cacheClass, CacheInterface::class)
            );
        }
        $cache = new $cacheClass($config['cache'] ?? []);

        $serviceFactory = new ServiceFactory($client);
        $this->backendManager = new BackendManager(
            $baseCacheKey,
            $cache,
            $client,
            $domains,
            $serviceFactory->getServicesByName($config['services'] ?? [], $config),
        );
    }

    /**
     * @param string $url
     *
     * @return array|mixed|null
     */
    public function get(string $url)
    {
        return $this->backendManager->get($url);
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->backendManager->setLogger($logger);
    }
}
