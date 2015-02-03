<?php

namespace Heise\Shariff;

use GuzzleHttp\Client;
use Heise\Shariff\Backend\BackendManager;
use Heise\Shariff\Backend\ServiceFactory;
use Zend\Cache\Storage\Adapter\Filesystem;

class Backend
{
    /** @var BackendManager */
    protected $backendManager;

    public function __construct($config)
    {
        $domain = $config["domain"];
        $clientOptions = [];
        if (isset($config['client'])) {
            $clientOptions = $config['client'];
        }
        $client = new Client(['defaults' => $clientOptions]);
        $baseCacheKey = md5(json_encode($config));

        $cache = new Filesystem();
        $options = $cache->getOptions();
        $options->setCacheDir(
            array_key_exists("cacheDir", $config["cache"])
            ? $config["cache"]["cacheDir"]
            : sys_get_temp_dir()
        );
        $options->setNamespace('Shariff');
        $options->setTtl($config["cache"]["ttl"]);

        if (function_exists('register_postsend_function')) {
            // for hhvm installations: executing after response / session close
            register_postsend_function(function () use ($cache) {
                $cache->clearExpired();
            });
        } else {
            // default
            $cache->clearExpired();
        }

        $serviceFactory = new ServiceFactory($client);
        $this->backendManager = new BackendManager(
            $baseCacheKey,
            $cache,
            $client,
            $domain,
            $serviceFactory->getServicesByName($config['services'], $config)
        );
    }


    public function get($url)
    {
        return $this->backendManager->get($url);
    }
}
