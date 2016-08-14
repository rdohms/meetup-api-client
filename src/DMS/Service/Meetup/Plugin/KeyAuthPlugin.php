<?php

namespace DMS\Service\Meetup\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class KeyAuthPlugin.
 *
 * This Guzzle plugin implements Key based authorization that is supported by the Meetup.com API
 */
class KeyAuthPlugin implements EventSubscriberInterface
{
    protected $key;

    /**
     * Constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            'request.before_send' => ['onRequestBeforeSend', -1000],
        ];
    }

    /**
     * Request before-send event handler.
     *
     * @param Event $event Event received
     *
     * @return array
     */
    public function onRequestBeforeSend(Event $event)
    {
        /** @var $request Request */
        $request = $event['request'];

        $this->signRequest($request);
    }

    /**
     * Adds "key" parameters as a Query Parameter.
     *
     * @param Request $request
     */
    protected function signRequest($request)
    {
        $url = $request->getUrl(true);
        $url->getQuery()->add('key', $this->key);

        $request->setUrl($url);
    }
}
