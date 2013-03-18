<?php
namespace DMS\Service\Meetup;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use Guzzle\Tests\GuzzleTestCase;

class MeetupKeyAuthClientTest extends GuzzleTestCase
{

    public function testFactory()
    {
        $client = $this->buildClient();

        $this->assertInstanceOf('DMS\Service\Meetup\MeetupKeyAuthClient', $client);
    }

    /**
     * @expectedException Guzzle\Common\Exception\InvalidArgumentException
     * @expectedExceptionMessage Config must contain a 'key' key
     */
    public function testFactoryValidation()
    {
        $config = array();
        MeetupKeyAuthClient::factory($config);
    }

    public function testMultiResultRequest()
    {
        $client = $this->buildClient();
        $this->setMockResponse($client, 'V2/GetRSVPs');

        $response = $client->getRSVPs(array('event_id' => 'some-id'));

        $this->assertInstanceOf('\DMS\Service\Meetup\Response\MultiResultResponse', $response);
        $this->assertCount(2, $response);
    }

    public function testSingleResultRequest()
    {
        $client = $this->buildClient();
        $this->setMockResponse($client, 'V2/GetRSVP');

        $response = $client->getRSVP(array('id' => '702769262'));

        $this->assertInstanceOf('\DMS\Service\Meetup\Response\SingleResultResponse', $response);

        $this->assertEquals('no', $response['response']);
    }

    protected function buildClient()
    {
        $config = array(
            'key' => 'mykey'
        );

        $client = MeetupKeyAuthClient::factory($config);

        return $client;
    }
}
