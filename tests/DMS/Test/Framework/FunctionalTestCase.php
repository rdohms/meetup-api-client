<?php

namespace DMS\Test\Framework;

use DMS\Service\Meetup\MeetupKeyAuthClient;

class FunctionalTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MeetupKeyAuthClient
     */
    protected $keyClient;

    protected function setUp()
    {
        parent::setUp();

        $configFile = __DIR__.'/../../../api_key.ini';

        if (!file_exists($configFile)) {
            $this->markTestSkipped('Functional Tests require an Oauth Key');
        }

        $config = parse_ini_file($configFile);

        $this->keyClient = MeetupKeyAuthClient::factory(['key' => $config['key']]);
    }
}
