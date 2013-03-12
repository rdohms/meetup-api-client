<?php
namespace DMS\Service\Meetup;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use Guzzle\Tests\GuzzleTestCase;

class MeetupKeyAuthClientTest extends GuzzleTestCase {

    public function testFactory()
    {
        $config = array(
            'key' => 'mykey'
        );

        $client = MeetupKeyAuthClient::factory($config);

        $this->assertInstanceOf('DMS\Service\Meetup\MeetupKeyAuthClient', $client);
    }

    /**
     * @expectedException Guzzle\Common\Exception\InvalidArgumentException
     * @expectedExceptionMessage Config must contain a 'key' key
     */
    public function testFactoryValidation()
    {
        $config = array();
        $client = MeetupKeyAuthClient::factory($config);
    }

}
