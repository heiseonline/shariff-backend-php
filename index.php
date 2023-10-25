<?php

require_once __DIR__ . '/vendor/autoload.php';

use Heise\Shariff\Backend;

/**
 * Demo Application using Shariff Backend
 */
class Application
{
    /**
     * Sample configuration
     *
     * @var array
     */
    private static $configuration = [
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
            'Flattr',
            'Pinterest',
            'Xing',
            'AddThis',
            'Buffer',
            'Vk'
        ]
    ];

    public static function run()
    {
        header('Content-type: application/json');

        $url = isset($_GET['url']) ? $_GET['url'] : '';
        if ($url) {
            $shariff = new Backend(self::$configuration);
            echo json_encode($shariff->get($url));
        }
        else {
            echo json_encode(null);
        }
    }
}

Application::run();
