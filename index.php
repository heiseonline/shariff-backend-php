<?php

namespace Heise\Shariff;

use Heise\Shariff\Backend;

// phpcs:disable PSR1.Files.SideEffects
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Demo Application using Shariff Backend
 *
 * @SuppressWarnings(PHPMD.Superglobals)
 */
class Application
{
    /**
     * Sample configuration
     *
     * @var array
     */
    private static array $configuration = [
        'cache' => [
            'ttl' => 60
        ],
        'domains' => [
            'www.heise.de',
            'www.ct.de'
        ],
        'services' => [
            'Facebook',
            'Reddit',
            'StumbleUpon',
            'Pinterest',
            'Xing',
            'Buffer',
            'Vk'
        ]
    ];

    public static function run()
    {
        header('Content-type: application/json');

        $url = $_GET['url'] ?? '';
        if ($url) {
            $shariff = new Backend(self::$configuration);
            echo json_encode($shariff->get($url));
        } else {
            echo json_encode(null);
        }
    }
}

Application::run();
