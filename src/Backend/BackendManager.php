<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Pool;
use Heise\Shariff\CacheInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BackendManager.
 */
class BackendManager
{
    /** @var string */
    protected $baseCacheKey;

    /** @var CacheInterface */
    protected $cache;

    /** @var ClientInterface */
    protected $client;

    /** @var array */
    protected $domains = [];

    /** @var ServiceInterface[] */
    protected $services;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param string             $baseCacheKey
     * @param CacheInterface     $cache
     * @param ClientInterface    $client
     * @param array|string       $domains
     * @param ServiceInterface[] $services
     */
    public function __construct(
        $baseCacheKey,
        CacheInterface $cache,
        ClientInterface $client,
        $domains,
        array $services
    ) {
        $this->baseCacheKey = $baseCacheKey;
        $this->cache = $cache;
        $this->client = $client;
        if (is_array($domains)) {
            $this->domains = $domains;
        } elseif (is_string($domains)) {
            trigger_error(
                'Passing a domain string is deprecated since 5.1, please use an array instead.',
                E_USER_DEPRECATED
            );
            $this->domains = [$domains];
        }
        $this->services = $services;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $url
     *
     * @return array|mixed|null
     */
    public function get($url)
    {
        // Changing configuration invalidates the cache
        $cacheKey = md5($url.$this->baseCacheKey);

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        if ($this->cache->hasItem($cacheKey)) {
            return json_decode($this->cache->getItem($cacheKey), true);
        }

        if (!$this->isValidDomain($url)) {
            return null;
        }

        $requests = array_map(
            function ($service) use ($url) {
                /* @var ServiceInterface $service */
                return $service->getRequest($url);
            },
            $this->services
        );

        /** @var ResponseInterface[]|TransferException[] $results */
        $results = Pool::batch($this->client, $requests);

        $counts = [];
        $i = 0;
        foreach ($this->services as $service) {
            if ($results[$i] instanceof TransferException) {
                if ($this->logger !== null) {
                    $this->logger->warning($results[$i]->getMessage(), ['exception' => $results[$i]]);
                }
            } else {
                try {
                    $content = $service->filterResponse($results[$i]->getBody()->getContents());
                    $json = json_decode($content, true);
                    $counts[$service->getName()] = is_array($json) ? (int) $service->extractCount($json) : 0;
                } catch (\Exception $e) {
                    if ($this->logger !== null) {
                        $this->logger->warning($e->getMessage(), ['exception' => $e]);
                    }
                }
                ++$i;
            }
        }

        $this->cache->setItem($cacheKey, json_encode($counts));

        return $counts;
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    private function isValidDomain($url)
    {
        if (!empty($this->domains)) {
            $parsed = parse_url($url);

            return in_array($parsed['host'], $this->domains, true);
        }

        return true;
    }
}
