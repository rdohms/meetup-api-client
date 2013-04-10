<?php
namespace DMS\Service\Meetup\Command;

use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Guzzle\Tests\GuzzleTestCase;

class MeetupResponseParserTest extends GuzzleTestCase
{
    public function testGetInstance()
    {
        $this->assertInstanceOf('DMS\Service\Meetup\Command\MeetupResponseParser', MeetupResponseParser::getInstance());
    }

    /**
     * @param $response
     * @param $expectedResponse
     *
     * @dataProvider provideForParse
     */
    public function testParse($response, $expectedResponse)
    {
        $command = $this->buildCommand($response);

        $responder = MeetupResponseParser::getInstance();

        $result = $responder->parse($command);

        switch($expectedResponse) {
            case 'multi':
                $this->assertInstanceOf('\DMS\Service\Meetup\Response\MultiResultResponse', $result);
                break;
            case 'single':
                $this->assertInstanceOf('\DMS\Service\Meetup\Response\SingleResultResponse', $result);
                $this->assertNotNull($result['a']);
                break;
            case 'basic':
                $this->assertInstanceOf('\Guzzle\Http\Message\Response', $result);
                break;
        }
    }

    protected function buildCommand($response)
    {
        $command = $this->getMockBuilder('\DMS\Service\Meetup\Command\MeetupCommand')
            ->disableOriginalConstructor()->getMock();

        $request = $this->getMockBuilder('\Guzzle\Http\Message\Request')
            ->disableOriginalConstructor()->getMock();

        $request->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        $command->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($request));

        return $command;
    }

    public function provideForParse()
    {
        return array(
            array(new Response(200, array('Content-Type' => 'application/json'), json_encode(array('results' => array(), 'meta' => array()))), 'multi'),
            array(new Response(200, array('Content-Type' => 'application/json'), json_encode(array('a' => 'b'))), 'single'),
            array(new Response(200, array('Content-Type' => 'text/plain'), 'sample=text&a=b'), 'single'),
            array(new Response(200), 'basic'),
        );
    }
}
