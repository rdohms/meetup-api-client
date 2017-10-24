<?php

namespace DMS\Service\Meetup;

use DMS\Service\Meetup\Exception\ClientException;
use DMS\Service\Meetup\Exception\ServerException;
use GuzzleHttp\Command\Exception\CommandClientException;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * Class Client
 *
 * @method --insert docs here--
 */
final class Client extends GuzzleClient
{
    /**
     * @param string $name
     * @param array  $args
     *
     * @return \GuzzleHttp\Command\ResultInterface|\GuzzleHttp\Promise\PromiseInterface
     * @throws ClientException
     * @throws ServerException
     */
    public function __call($name, array $args)
    {
        try {
            return parent::__call($name, $args);
        } catch (CommandClientException $e) {
            if ($e->getResponse()->getStatusCode() >= 500) {
                throw ServerException::fromGuzzleException($e);
            }

            throw ClientException::fromGuzzleException($e);
        }
    }

}
