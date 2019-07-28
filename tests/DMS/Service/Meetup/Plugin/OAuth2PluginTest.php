<?php

namespace DMS\Service\Meetup\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use PHPUnit_Framework_TestCase;

class OAuth2PluginTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OAuth2Plugin
     */
    protected $plugin;

    /**
     * @var string
     */
    protected $access_token = 'my_access_token';

    protected function setUp()
    {
        $this->plugin = new OAuth2Plugin($this->access_token);
    }

    public function testGetSubscribedEvents()
    {
        $events = OAuth2Plugin::getSubscribedEvents();

        $this->assertArrayHasKey('request.before_send', $events);
    }

    public function testOnRequestBeforeSendGET()
    {
        $request = new Request('GET', 'www.url.com');

        $event = new Event(array('request' => $request));

        $this->plugin->onRequestBeforeSend($event);

        $this->assertEquals('Bearer ' . $this->access_token, $request->getHeader('Authorization'));
    }

    public function testOnRequestBeforeSendPOST()
    {
        $request = new Request('POST', 'www.url.com');

        $event = new Event(array('request' => $request));

        $this->plugin->onRequestBeforeSend($event);

        $this->assertEquals('Bearer ' . $this->access_token, $request->getHeader('Authorization'));
    }
}
