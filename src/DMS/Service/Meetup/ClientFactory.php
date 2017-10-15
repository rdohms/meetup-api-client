<?php

namespace DMS\Service\Meetup;

use Guzzle\Service\Loader\JsonLoader;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use Symfony\Component\Config\FileLocator;

final class ClientFactory
{
    private const DESCRIPTION_PATH = __DIR__ . '/../../../../description';

    public static function buildClient()
    {

        $config = [
            'base_uri' => 'http://api.meetup.com/',
        ];

        $locator    = new FileLocator([self::DESCRIPTION_PATH]);
        $jsonLoader = new JsonLoader($locator);

        $description = $jsonLoader->load($locator->locate('meetup.json'));
        $description = new Description($description);

        $client = new GuzzleClient($config);

        return new Client($client, $description);
    }
}
