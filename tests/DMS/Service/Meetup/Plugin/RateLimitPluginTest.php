<?php


namespace DMS\Service\Meetup\Plugin;


use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;

class RateLimitPluginTest extends \PHPUnit_Framework_TestCase
{

    public function testOnRequestSuccess()
    {
        $event = new Event();
        $response = new Response(200, array(
            'X-RateLimit-Limit'     => array(30),
            'X-RateLimit-Remaining' => array(29),
            'X-RateLimit-Reset'     => array(10),
        ));

        $event['response'] = $response;

        $plugin = new RateLimitPlugin();
        $plugin->onRequestSuccess($event);

        $this->assertAttributeEquals((string) $response->getHeader('X-RateLimit-Limit'), 'rateLimitMax', $plugin);
        $this->assertAttributeEquals(
            (string) $response->getHeader('X-RateLimit-Remaining'),
            'rateLimitRemaining',
            $plugin
        );
        $this->assertAttributeEquals((string) $response->getHeader('X-RateLimit-Reset'), 'rateLimitReset', $plugin);
        $this->assertAttributeEquals(true, 'rateLimitEnabled', $plugin);
    }

    public function testOnRequestSuccessWithNoLimit()
    {
        $event = new Event();
        $response = new Response(200, array());

        $event['response'] = $response;

        $plugin = new RateLimitPlugin();
        $plugin->onRequestSuccess($event);

        $this->assertAttributeEquals(false, 'rateLimitEnabled', $plugin);
    }

    public function testOnRequestSuccessAvoidDivisionByZero()
    {
        $event = new Event();
        $response = new Response(200, array(
            'X-RateLimit-Limit'     => array(0),
        ));

        $event['response'] = $response;

        $plugin = new RateLimitPlugin();
        $plugin->onRequestSuccess($event);

        $this->assertAttributeEquals(1, 'rateLimitMax', $plugin);
        $this->assertAttributeEquals(true, 'rateLimitEnabled', $plugin);
    }

    public function testOnBeforeSendSlowsDown()
    {
        $plugin = $this->setupProxyPluginWithValues(10, 4, 10);
        $plugin->onBeforeSend();

        $this->assertGreaterThan(0, $plugin->slowdowns);
    }

    public function testOnBeforeSendRespectsCustomFactor()
    {
        $plugin = $this->setupProxyPluginWithValues(10, 4, 10, 0.75);
        $plugin->onBeforeSend();

        $this->assertEquals(0, $plugin->slowdowns);
    }

    /**
     * @param $limit
     * @param $remaining
     * @param $reset
     * @return RateLimitPlugin | RateLimitPluginProxy
     */
    protected function setupProxyPluginWithValues($limit, $remaining, $reset, $factor = null)
    {
        $event = new Event();
        $response = new Response(200, array(
            'X-RateLimit-Limit'     => array($limit),
            'X-RateLimit-Remaining' => array($remaining),
            'X-RateLimit-Reset'     => array($reset),
        ));

        $event['response'] = $response;

        $plugin = ($factor === null)? new RateLimitPluginProxy() : new RateLimitPluginProxy($factor);
        $plugin->onRequestSuccess($event);

        return $plugin;
    }
}
