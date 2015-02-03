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
        $this->assertInternalType('int', $counts['facebook']);
        $this->assertGreaterThanOrEqual(0, $counts['facebook']);

        $this->assertArrayHasKey('flattr', $counts);
        $this->assertInternalType('int', $counts['flattr']);
        $this->assertGreaterThanOrEqual(0, $counts['flattr']);

        $this->assertArrayHasKey('googleplus', $counts);
        $this->assertInternalType('int', $counts['googleplus']);
        $this->assertGreaterThanOrEqual(0, $counts['googleplus']);

        $this->assertArrayHasKey('linkedin', $counts);
        $this->assertInternalType('int', $counts['linkedin']);
        $this->assertGreaterThanOrEqual(0, $counts['linkedin']);

        $this->assertArrayHasKey('pinterest', $counts);
        $this->assertInternalType('int', $counts['pinterest']);
        $this->assertGreaterThanOrEqual(0, $counts['pinterest']);

        $this->assertArrayHasKey('reddit', $counts);
        $this->assertInternalType('int', $counts['reddit']);
        $this->assertGreaterThanOrEqual(0, $counts['reddit']);

        $this->assertArrayHasKey('stumbleupon', $counts);
        $this->assertInternalType('int', $counts['stumbleupon']);
        $this->assertGreaterThanOrEqual(0, $counts['stumbleupon']);

        $this->assertArrayHasKey('twitter', $counts);
        $this->assertInternalType('int', $counts['twitter']);
        $this->assertGreaterThanOrEqual(0, $counts['twitter']);

        // It seems Xing is blocking Travis from time to time - maybe caused by DOS protection
        if (!getenv("TRAVIS")) {
            $this->assertArrayHasKey('xing', $counts);
            $this->assertInternalType('int', $counts['xing']);
            $this->assertGreaterThanOrEqual(0, $counts['xing']);
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

    public function testClientOptions()
    {
        $shariff = new Backend(array(
            "domain"   => 'www.heise.de',
            "cache"    => array("ttl" => 1),
            "services" => $this->services,
            "client" => array(
                "timeout" => 0.005,
                "connect_timeout" => 0.005
            )
        ));

        $counts = $shariff->get('http://www.heise.de');

        // expect no response in 5 ms
        $this->assertCount(0, $counts);
    }
}
