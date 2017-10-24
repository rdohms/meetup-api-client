<?php

namespace DMS\Service\Meetup;

use DMS\Service\Meetup\Config\ClientConfig;
use Guzzle\Service\Loader\JsonLoader;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Symfony\Component\Config\FileLocator;

final class ClientFactory
{
    private const DESCRIPTION_PATH = __DIR__ . '/../../../../description';

    public static function buildClient(ClientConfig $config)
    {

        $default = [
            'base_uri' => 'http://api.meetup.com/',
        ];

        $locator    = new FileLocator([self::DESCRIPTION_PATH]);
        $jsonLoader = new JsonLoader($locator);

        $description = $jsonLoader->load($locator->locate('meetup.json'));
        $description = new Description($description);

        $stack = HandlerStack::create();

        foreach ($config->getMiddleware() as $name => $middleware) {
            $stack->push(Middleware::mapRequest($middleware), $name);
        }

        $config = array_merge($default, [
            'handler' => $stack
        ]);

        $client = new GuzzleClient($config);


        return new Client($client, $description);
    }
}
