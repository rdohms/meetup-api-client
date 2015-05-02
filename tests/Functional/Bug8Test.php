<?php


namespace DMS\Functional;

use DMS\Test\Framework\FunctionalTestCase;

class Bug8Test extends FunctionalTestCase
{
    public function testGetGroups()
    {
        $result = $this->keyClient->getGroups(array('country' => 'NL', 'city' => 'Amsterdam', 'topic' => 'php'));

        $this->assertInstanceOf('DMS\Service\Meetup\Response\MultiResultResponse', $result);
    }

    public function testGetGroupsSingle()
    {
        $result = $this->keyClient->getGroups(array('group_urlname' => 'amsterdamphp'));

        $this->assertInstanceOf('DMS\Service\Meetup\Response\MultiResultResponse', $result);
    }
}
