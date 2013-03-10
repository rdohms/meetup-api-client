<?php

namespace DMS\Service\Meetup;

use Guzzle\Common\Collection;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Meetup.com API Client based on OAuth 1.0
 *
 * Docs: OAuth 1.0a signed requests -- for apps that carry out actions for many Meetup users.
 *
 * @link http://www.meetup.com/meetup_api/auth/
 * @package DMS\Service\Meetup
 */
class MeetupOAuthClient extends AbstractMeetupClient
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
        return array(
            'consumer_key',
            'consumer_secret',
            'base_url'
        );
    }

    /**
     * Factory Method to build new Client
     *
     * @param array $config
     * @return MeetupOAuthClient
     */
    public static function factory($config = array())
    {
        $configuration = static::buildConfig($config);

        $client = new self($configuration->get('base_url'), $configuration);

        $client->addSubscriber(new OauthPlugin(array(
                'consumer_key'    => $configuration->get('consumer_key'),
                'consumer_secret' => $configuration->get('consumer_secret'),
                'token'           => false,
                'token_secret'    => false
            )));

        static::loadDefinitions($client);

        return $client;
    }

}
