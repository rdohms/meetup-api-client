<?php

use Guzzle\Tests\GuzzleTestCase;

include __DIR__.'/../vendor/autoload.php';

Guzzle\Tests\GuzzleTestCase::setServiceBuilder(
    Guzzle\Service\Builder\ServiceBuilder::factory(
        array(
            'test.meetup.key'   => array(
                'class'  => 'DMS.Service.Meetup.MeetupKeyAuthClient',
                'params' => array(
                    'key' => 'mykey'
                )
            ),
            'test.meetup.oauth' => array(
                'class'  => 'DMS.Service.Meetup.MeetupOauthAuthClient',
                'params' => array(
                    'consumer_key'    => 'key',
                    'consumer_secret' => 'secret',
                    'token'           => 'token',
                    'token_secret'    => 'token_secret'
                )
            )
        )
    )
);


$basePath = __DIR__ . '/mock/';
GuzzleTestCase::setMockBasePath($basePath);
