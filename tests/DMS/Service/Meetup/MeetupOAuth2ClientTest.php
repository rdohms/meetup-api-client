<?php

namespace DMS\Service\Meetup;

use Guzzle\Tests\GuzzleTestCase;

class MeetupOAuth2ClientTest extends GuzzleTestCase
{
    public function testFactory()
    {
        $config = array(
            'access_token'    => '**',
        );

        $client = MeetupOAuth2Client::factory($config);

        $this->assertInstanceOf('DMS\Service\Meetup\MeetupOAuth2Client', $client);
    }

    /**
     * @expectedException Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testFactoryValidation()
    {
        $config = array();
        MeetupOAuth2Client::factory($config);
    }
}
