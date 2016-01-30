<?php
namespace Heise\Tests\Shariff;

use Heise\Shariff\Backend;
use Zend\Cache\Exception\ExtensionNotLoadedException;
use Zend\Cache\Exception\OutOfSpaceException;

/**
 * Class ShariffTest
 */
class ShariffTest extends \PHPUnit_Framework_TestCase
{
    /***
     * @var string[]
     */
    protected $services = array(
        "Facebook",
        // "Flattr",
        "GooglePlus",
        "LinkedIn",
        "Pinterest",
        "Reddit",
        "StumbleUpon",
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

        // $this->assertArrayHasKey('flattr', $counts);
        // $this->assertInternalType('int', $counts['flattr']);
        // $this->assertGreaterThanOrEqual(0, $counts['flattr']);

        $this->assertArrayHasKey('googleplus', $counts);
        $this->assertInternalType('int', $counts['googleplus']);
        $this->assertGreaterThanOrEqual(0, $counts['googleplus']);

        $this->assertArrayHasKey('linkedin', $counts);
        $this->assertInternalType('int', $counts['linkedin']);
        $this->assertGreaterThanOrEqual(0, $counts['linkedin']);

        $this->assertArrayHasKey('pinterest', $counts);
        $this->assertInternalType('int', $counts['pinterest']);
        $this->assertGreaterThanOrEqual(0, $counts['pinterest']);

        $this->assertArrayHasKey('stumbleupon', $counts);
        $this->assertInternalType('int', $counts['stumbleupon']);
        $this->assertGreaterThanOrEqual(0, $counts['stumbleupon']);

        // It seems Xing and reddit are blocking Travis from time to time - maybe caused by DOS protection
        if (!getenv("TRAVIS")) {
            $this->assertArrayHasKey('xing', $counts);
            $this->assertInternalType('int', $counts['xing']);
            $this->assertGreaterThanOrEqual(0, $counts['xing']);

            $this->assertArrayHasKey('reddit', $counts);
            $this->assertInternalType('int', $counts['reddit']);
            $this->assertGreaterThanOrEqual(0, $counts['reddit']);
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

    public function testApcCache()
    {
        if ('hhvm' == getenv('TRAVIS_PHP_VERSION')) {
            $this->markTestSkipped('APC seems to work for hhvm');
        }

        $this->setExpectedException(ExtensionNotLoadedException::class);
        new Backend(array(
            "domain"   => 'www.heise.de',
            "cache"    => array("adapter" => "Apc", "ttl" => 0),
            "services" => $this->services
        ));
        $this->fail('APC should not be enabled for test');
    }

    public function testCacheOptions()
    {
        $this->setExpectedException(OutOfSpaceException::class);
        $shariff = new Backend(array(
            "domain"   => 'www.heise.de',
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
