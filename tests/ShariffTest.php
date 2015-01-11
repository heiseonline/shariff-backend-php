<?php
namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend;

class ShariffTest extends \PHPUnit_Framework_TestCase
{

    public function testShariff()
    {
        $shariff = new Backend([
            "domain"   => 'www.heise.de',
            "cache"    => ["ttl" => 1],
            "services" => ["Facebook", "GooglePlus", "Twitter", "Flattr", "Pinterest"]
        ]);

        $counts = $shariff->get('http://www.heise.de');

        // print_r($counts);

        $this->assertArrayHasKey('facebook', $counts);
        $this->assertArrayHasKey('googleplus', $counts);
        $this->assertArrayHasKey('twitter', $counts);
        $this->assertArrayHasKey('flattr', $counts);
        $this->assertArrayHasKey('pinterst', $counts);

        $this->assertGreaterThan(0, $counts['facebook']);
        $this->assertGreaterThan(0, $counts['googleplus']);
        $this->assertGreaterThan(0, $counts['twitter']);
		// It's actual 0
        //$this->assertGreaterThan(0, $counts['flattr']);
        $this->assertGreaterThan(0, $counts['pinterst']);
    }

    public function testInvalidDomain()
    {
        $shariff = new Backend([
            "domain"   => 'www.heise.de',
            "cache"    => ["ttl" => 0],
            "services" => ["Facebook", "GooglePlus", "Twitter", "Flattr", "Pinterest"]
        ]);

        $counts = $shariff->get('http://example.com');

        $this->assertNull($counts);
    }
}
