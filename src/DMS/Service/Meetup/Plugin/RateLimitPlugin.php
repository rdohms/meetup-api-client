<?php

namespace DMS\Service\Meetup\Plugin;

use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RateLimitPlugin
 *
 * This plugin watches the X-Rate-Limit headers of the Meetup API
 *
 * @package DMS\Service\Meetup\Plugin
 */
class RateLimitPlugin implements EventSubscriberInterface
{
    /**
     * @var bool $rateLimitEnabled
     */
    private $rateLimitEnabled = true;

    /**
     * @var int $rateLimitMax
     */
    private $rateLimitMax = 200;

    /**
     * @var int $rateLimitCurrent
     */
    private $rateLimitCurrent = 0;

    /**
     * @var int $rateLimitPercentage
     */
    private $rateLimitPercentage = 0;

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
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000),
            'request.success' => array('onRequestSuccess', -1000),
        );
    }

    /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     * @return array
     */
    public function onRequestSuccess(Event $event)
    {
        /** @var Response $response */
        $response = $event['response'];
        $responseHeaders = $response->getHeaders()->toArray();

        if (!isset($responseHeaders['X-RateLimit-Limit'])) {
            $this->rateLimitEnabled = false;
            return;
        }

        // Determine rateLimitMax and rateLimitCurrent from headers
        $this->rateLimitMax = $responseHeaders['X-RateLimit-Limit'][0];
        $remaining = $responseHeaders['X-RateLimit-Remaining'][0];
        $this->rateLimitCurrent = $this->rateLimitMax - $remaining;

        // Prevent division by zero
        if ($this->rateLimitMax == 0) {
            $this->rateLimitMax = 1;
        }

        // Calculate percentage and keep within bounds
        $percentage = round($this->rateLimitCurrent / $this->rateLimitMax * 100, 2);
        $percentage = min($percentage, 100);
        $percentage = max($percentage, 0);
        $this->rateLimitPercentage = $percentage;

        return;
    }

    /**
     * Performs slowdown when rate limiting is enabled and nearing limit
     *
     * @param Event $event
     */
    public function onRequestBeforeSend(Event $event)
    {
        if ($this->rateLimitEnabled) {
            if ($this->rateLimitPercentage > 50) {
                // TODO: Calculate relative sleep time until X-RateLimit-Reset
                usleep(500);
            }
        }

        return;
    }
}