<?php
namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend;
use Laminas\Cache\Exception\OutOfSpaceException;
use PHPUnit\Framework as PHPUnit;

/**
 * Class ShariffTest
 */
class ShariffTest extends PHPUnit\TestCase
{
    /***
     * @var string[]
     */
    protected $services = array(
        // "Facebook",
        // "Flattr",
        "Pinterest",
        "Reddit",
        // "StumbleUpon",
        "Xing",
        "Buffer",
        "Vk"
    );

    public function testShariff()
    {
        $shariff = new Backend(array(
            "domains"   => array('www.heise.de'),
            "cache"    => array("ttl" => 1),
            "services" => $this->services
        ));

        $counts = $shariff->get('http://www.heise.de');

        // $this->assertArrayHasKey('flattr', $counts);
        if (array_key_exists('flattr', $counts)) {
            $this->assertIsInt($counts['flattr']);
            $this->assertGreaterThanOrEqual(0, $counts['flattr']);
        }

        // $this->assertArrayHasKey('pinterest', $counts);
        if (array_key_exists('pinterest', $counts)) {
            $this->assertIsInt($counts['pinterest']);
            $this->assertGreaterThanOrEqual(0, $counts['pinterest']);
        }

        // $this->assertArrayHasKey('stumbleupon', $counts);
        if (array_key_exists('stumbleupon', $counts)) {
            $this->assertIsInt($counts['stumbleupon']);
            $this->assertGreaterThanOrEqual(0, $counts['stumbleupon']);
        }

        // $this->assertArrayHasKey('xing', $counts);
        if (array_key_exists('xing', $counts)) {
            $this->assertIsInt($counts['xing']);
            $this->assertGreaterThanOrEqual(0, $counts['xing']);
        }

        // $this->assertArrayHasKey('reddit', $counts);
        if (array_key_exists('reddit', $counts)) {
            $this->assertIsInt($counts['reddit']);
            $this->assertGreaterThanOrEqual(0, $counts['reddit']);
        }

        // $this->assertArrayHasKey('buffer', $counts);
        if (array_key_exists('buffer', $counts)) {
            $this->assertIsInt($counts['buffer']);
            $this->assertGreaterThanOrEqual(0, $counts['buffer']);
        }

        // $this->assertArrayHasKey('vk', $counts);
        if (array_key_exists('vk', $counts)) {
            $this->assertIsInt($counts['vk']);
            $this->assertGreaterThanOrEqual(0, $counts['vk']);
        }
    }

    public function testInvalidDomain()
    {
        $shariff = new Backend(array(
            "domains"   => array('www.heise.de'),
            "cache"    => array("ttl" => 0),
            "services" => $this->services
        ));

        $counts = $shariff->get('http://example.com');

        $this->assertNull($counts);
    }

    public function testCacheOptions()
    {
        $this->expectException(OutOfSpaceException::class);
        $shariff = new Backend(array(
            "domains"   => array('www.heise.de'),
            "cache"    => array(
                "adapter" => "Memory",
                "adapterOptions" => array("memoryLimit" => 10),
                "ttl" => 0
            ),
            "services" => $this->services
        ));
        $shariff->get('http://www.heise.de');
        $this->fail('10 bytes should not be enough for the cache');
    }

    public function testClientOptions()
    {
        $this->markTestSkipped(
            "Some APIs are too fast for this. We need mock APIs."
        );

        $shariff = new Backend(array(
            "domains"   => array('www.heise.de'),
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
