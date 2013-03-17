<?php

namespace DMS\Service\Meetup\Command;

use DMS\Service\Meetup\Response\MultiResultResponse;
use DMS\Service\Meetup\Response\SingleResultResponse;
use Guzzle\Http\Message\Response;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Command\DefaultResponseParser;

class MeetupResponseParser extends DefaultResponseParser
{
    /**
     * Get a cached instance of the default response parser
     * @return self
     * @codeCoverageIgnore
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * {@inheritdoc}
     *
     * @param CommandInterface $command
     * @return array|MultiResultResponse|SingleResultResponse|Response|mixed
     */
    public function parse(CommandInterface $command)
    {
        $response      = $command->getRequest()->getResponse();
        $responseArray = $response->json();

        // If there is no Body, just return the Response
        if ( ! $response->getBody()) {
            return $response;
        }

        // Handle multi-result responses
        if (array_key_exists('results', $responseArray)) {
            return $this->createMultiResultResponse($response, $responseArray);
        }

        return $this->createSingleResultResponse($response, $responseArray);
    }

    /**
     * Create a Multi-Response Object
     *
     * @param Response $response
     * @param array $responseArray
     * @return \DMS\Service\Meetup\Response\MultiResultResponse
     */
    protected function createMultiResultResponse($response, $responseArray)
    {
        $response = new MultiResultResponse($response->getStatusCode(), $response->getHeaders(), $response->getBody());

        $response->setMetadata($responseArray['meta']);
        $response->setData($responseArray['results']);

        return $response;
    }

    /**
     * Create a Single-Response Object
     *
     * @param Response $response
     * @param array $responseArray
     * @return \DMS\Service\Meetup\Response\SingleResultResponse
     */
    protected function createSingleResultResponse($response, $responseArray)
    {
        $response = new SingleResultResponse($response->getStatusCode(), $response->getHeaders(), $response->getBody());

        $response->setData($responseArray);

        return $response;
    }
}
