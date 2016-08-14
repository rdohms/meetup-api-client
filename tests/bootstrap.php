<?php

use Guzzle\Tests\GuzzleTestCase;

include __DIR__.'/../vendor/autoload.php';

Guzzle\Tests\GuzzleTestCase::setServiceBuilder(
    Guzzle\Service\Builder\ServiceBuilder::factory(
        [
            'test.meetup.key'   => [
                'class'  => 'DMS.Service.Meetup.MeetupKeyAuthClient',
                'params' => [
                    'key' => 'mykey',
                ],
            ],
            'test.meetup.oauth' => [
                'class'  => 'DMS.Service.Meetup.MeetupOauthAuthClient',
                'params' => [
                    'consumer_key'    => 'key',
                    'consumer_secret' => 'secret',
                    'token'           => 'token',
                    'token_secret'    => 'token_secret',
                ],
            ],
        ]
    )
);


$basePath = __DIR__.'/mock/';
GuzzleTestCase::setMockBasePath($basePath);
