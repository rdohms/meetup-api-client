<?php
namespace DMS\Service\Meetup\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use PHPUnit_Framework_TestCase;

class KeyAuthPluginTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var KeyAuthPlugin
     */
    protected $plugin;

    /**
     * @var string
     */
    protected $key = 'my_key';

    protected function setUp()
    {
        $this->plugin = new KeyAuthPlugin($this->key);
    }

    public function testGetSubscribedEvents()
    {
        $events = KeyAuthPlugin::getSubscribedEvents();

        $this->assertArrayHasKey('request.before_send', $events);
    }

    public function testOnRequestBeforeSendGET()
    {
        $request = new Request('GET', 'www.url.com');

        $event = new Event(array('request' => $request));

        $this->plugin->onRequestBeforeSend($event);

        $this->assertContains('key='.$this->key, $request->getUrl());
    }

    public function testOnRequestBeforeSendPOST()
    {
        $request = new Request('POST', 'www.url.com');

        $event = new Event(array('request' => $request));

        $this->plugin->onRequestBeforeSend($event);

        $this->assertContains('key='.$this->key, $request->getUrl());
    }
}
