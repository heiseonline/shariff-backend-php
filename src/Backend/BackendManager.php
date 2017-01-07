<?php

namespace Heise\Shariff\Backend;

use GuzzleHttp\ClientInterface;
use Heise\Shariff\CacheInterface;
use Http\Client\Common\BatchClient;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;
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

    /** @var ClientInterface|HttpClient */
    protected $client;

    /** @var array */
    protected $domains = [];

    /** @var ServiceInterface[] */
    protected $services;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param string                     $baseCacheKey
     * @param CacheInterface             $cache
     * @param ClientInterface|HttpClient $client
     * @param array|string               $domains
     * @param ServiceInterface[]         $services
     */
    public function __construct(
        $baseCacheKey,
        CacheInterface $cache,
        $client,
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

        /** @var RequestInterface[] $requests */
        $requests = array_map(
            function ($service) use ($url) {
                /* @var ServiceInterface $service */
                return $service->getRequest($url);
            },
            $this->services
        );

        $batchClient = new BatchClient($this->client);
        $batchResult = $batchClient->sendRequests($requests);

        if (null !== $this->logger && !$batchResult->hasResponses()) {
            $this->logger->notice('The response list is empty.');
        }

        $counts = [];

        for ($i = 0;$i < count($this->services);++$i) {
            $service = $this->services[$i];
            $request = $requests[$i];

            if ($batchResult->isSuccessful($request)) {
                $response = $batchResult->getResponseFor($request);

                try {
                    $content = $service->filterResponse($response->getBody()->getContents());
                    $counts[$service->getName()] = (int) $service->extractCount(json_decode($content, true));
                } catch (\Exception $e) {
                    if ($this->logger !== null) {
                        $this->logger->warning($e->getMessage(), ['exception' => $e]);
                    }
                }
            }

            if (null !== $this->logger && $batchResult->isFailed($request)) {
                $exception = $batchResult->getExceptionFor($request);

                if ($exception instanceof \Exception) {
                    $this->logger->warning($exception->getMessage(), ['exception' => $exception]);
                }
            }
        }

        $this->cache->setItem($cacheKey, json_encode($counts));

        return $counts;
    }
}
