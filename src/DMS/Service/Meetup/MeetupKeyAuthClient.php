<?php

namespace DMS\Service\Meetup;

use DMS\Service\Meetup\Plugin\KeyAuthPlugin;

/**
 * Meetup.com API Client based on simple key authentication
 *
 * Docs: API key as a parameter -- for server-side apps acting on behalf of a single user.
 *
 * @link http://www.meetup.com/meetup_api/auth/
 * @package DMS\Service\Meetup
 */
class MeetupKeyAuthClient extends AbstractMeetupClient
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getDefaultParameters()
    {
        return array(
            'base_url' => '{scheme}://api.meetup.com/',
            'scheme'   => 'http',
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getRequiredParameters()
    {
        return array('key', 'base_url');
    }

    /**
     * Factory Method to build new Client
     *
     * @param array $config
     * @return MeetupKeyAuthClient
     */
    public static function factory($config = array())
    {
        $configuration = static::buildConfig($config);

        $client = new self($configuration->get('base_url'), $configuration);

        $client->addSubscriber(new KeyAuthPlugin($configuration->get('key')));

        static::loadDefinitions($client);
        static::toggleRateLimitingPlugin($client, $config);

        return $client;
    }
}
