<?php

namespace DMS\Service\Meetup;

use DMS\Service\Meetup\Plugin\OAuth2Plugin;

/**
 * Meetup.com API Client based on OAuth 2.0.
 *
 * Docs: OAuth 2.0 requests -- for apps that carry out actions for many Meetup users.
 *
 * @link http://www.meetup.com/meetup_api/auth/
 */
class MeetupOAuth2Client extends AbstractMeetupClient
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
            'scheme'   => 'https',
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getRequiredParameters()
    {
        return array();
    }

    /**
     * Factory Method to build new Client.
     *
     * @param array $config
     *
     * @return MeetupOAuthClient
     */
    public static function factory($config = array())
    {
        $configuration = static::buildConfig($config);

        $client = new self($configuration->get('base_url'), $configuration);

        $client->addSubscriber(
            new OAuth2Plugin($configuration->get('access_token')
            )
        );

        static::loadDefinitions($client);
        static::toggleRateLimitingPlugin($client, $config);

        return $client;
    }
}
