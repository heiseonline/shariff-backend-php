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
            "services" => ["Facebook", "GooglePlus", "Twitter"]
        ]);

        $counts = $shariff->get('http://www.heise.de');

        // print_r($counts);

        $this->assertArrayHasKey('facebook', $counts);
        $this->assertArrayHasKey('googleplus', $counts);
        // $this->assertArrayHasKey('twitter', $counts);

        $this->assertGreaterThan(0, $counts['facebook']);
        $this->assertGreaterThan(0, $counts['googleplus']);
        // $this->assertGreaterThan(0, $counts['twitter']);
    }

    public function testInvalidDomain()
    {
        $shariff = new Backend([
            "domain"   => 'www.heise.de',
            "cache"    => ["ttl" => 0],
            "services" => ["Facebook", "GooglePlus", "Twitter"]
        ]);

        $counts = $shariff->get('http://example.com');

        $this->assertNull($counts);
    }
}
