<?php
namespace DMS\Service\Meetup\Command;

use Guzzle\Tests\GuzzleTestCase;

class MeetupCommandTest extends GuzzleTestCase
{
    public function testGetResponseParser()
    {
        $command = new MeetupCommand();

        $this->assertInstanceOf('DMS\Service\Meetup\Command\MeetupResponseParser', $command->getResponseParser());
    }
}
