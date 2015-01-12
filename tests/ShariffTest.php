<?php
namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend;

class ShariffTest extends \PHPUnit_Framework_TestCase
{
    protected $services = [
        "Facebook",
        "Flattr",
        "GooglePlus",
        "LinkedIn",
        "Pinterest",
        "Reddit",
        "StumbleUpon",
        "Twitter"
    ];

    public function testShariff()
    {
        $shariff = new Backend([
            "domain"   => 'www.heise.de',
            "cache"    => ["ttl" => 1],
            "services" => $this->services
        ]);

        $counts = $shariff->get('http://www.heise.de');

        // print_r($counts);

        $this->assertArrayHasKey('facebook', $counts);
        $this->assertArrayHasKey('flattr', $counts);
        $this->assertArrayHasKey('googleplus', $counts);
        $this->assertArrayHasKey('linkedin', $counts);
        $this->assertArrayHasKey('pinterest', $counts);
        $this->assertArrayHasKey('reddit', $counts);
        $this->assertArrayHasKey('stumbleupon', $counts);
        $this->assertArrayHasKey('twitter', $counts);

        $this->assertGreaterThan(0, $counts['facebook']);
        $this->assertGreaterThan(0, $counts['googleplus']);
        $this->assertGreaterThan(0, $counts['linkedin']);
        $this->assertGreaterThan(0, $counts['pinterest']);
        $this->assertGreaterThan(0, $counts['reddit']);
        $this->assertGreaterThan(0, $counts['stumbleupon']);
        $this->assertGreaterThan(0, $counts['twitter']);
        //$this->assertGreaterThan(0, $counts['flattr']); // It's actual 0
    }

    public function testInvalidDomain()
    {
        $shariff = new Backend([
            "domain"   => 'www.heise.de',
            "cache"    => ["ttl" => 0],
            "services" => $this->services
        ]);

        $counts = $shariff->get('http://example.com');

        $this->assertNull($counts);
    }
}
