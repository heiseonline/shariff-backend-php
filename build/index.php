<?php
require_once __DIR__.'/vendor/autoload.php';

use Heise\Shariff\Backend;
use Zend\Config\Reader\Json;

class Application
{
    public static function run()
    {
        header('Content-type: application/json');

        if (!isset($_GET["url"])) {
            echo json_encode(null);
            return;
        }

        $reader = new Json();

        $shariff = new Backend($reader->fromFile('shariff.json'));
        echo json_encode($shariff->get($_GET["url"]));
    }
}

Application::run();
