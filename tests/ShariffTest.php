<?php
namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend;

class ShariffTest extends \PHPUnit_Framework_TestCase
{
    protected $services = array(
        "Facebook",
        "Flattr",
        "GooglePlus",
        "LinkedIn",
        "Pinterest",
        "Reddit",
        "StumbleUpon",
        "Twitter",
        "Xing"
    );

    public function testShariff()
    {
        $shariff = new Backend(array(
            "domain"   => 'www.heise.de',
            "cache"    => array("ttl" => 1),
            "services" => $this->services
        ));

        $counts = $shariff->get('http://www.heise.de');

        $this->assertArrayHasKey('facebook', $counts);
        $this->assertGreaterThan(0, $counts['facebook']);

        $this->assertArrayHasKey('flattr', $counts);
        $this->assertGreaterThan(-1, $counts['flattr']);

        $this->assertArrayHasKey('googleplus', $counts);
        $this->assertGreaterThan(0, $counts['googleplus']);

        $this->assertArrayHasKey('linkedin', $counts);
        $this->assertGreaterThan(0, $counts['linkedin']);

        $this->assertArrayHasKey('pinterest', $counts);
        $this->assertGreaterThan(0, $counts['pinterest']);

        $this->assertArrayHasKey('reddit', $counts);
        $this->assertGreaterThan(0, $counts['reddit']);

        $this->assertArrayHasKey('stumbleupon', $counts);
        $this->assertGreaterThan(0, $counts['stumbleupon']);

        $this->assertArrayHasKey('twitter', $counts);
        $this->assertGreaterThan(0, $counts['twitter']);

        // It seems Xing is blocking Travis from time to time - maybe coused by DOS protection
        if (!getenv("TRAVIS")) {
            $this->assertArrayHasKey('xing', $counts);
            $this->assertGreaterThan(0, $counts['xing']);
        }
    }

    public function testInvalidDomain()
    {
        $shariff = new Backend(array(
            "domain"   => 'www.heise.de',
            "cache"    => array("ttl" => 0),
            "services" => $this->services
        ));

        $counts = $shariff->get('http://example.com');

        $this->assertNull($counts);
    }
}
