<?php
namespace DMS\Service\Meetup;

use Guzzle\Tests\GuzzleTestCase;

class MeetupOAuthClientTest extends GuzzleTestCase
{

    public function testFactory()
    {
        $config = array(
            'consumer_key'    => '**',
            'consumer_secret' => '**',
        );

        $client = MeetupOAuthClient::factory($config);

        $this->assertInstanceOf('DMS\Service\Meetup\MeetupOAuthClient', $client);
    }

    /**
     * @expectedException Guzzle\Common\Exception\InvalidArgumentException
     */
    public function testFactoryValidation()
    {
        $config = array();
        MeetupOAuthClient::factory($config);
    }
}
