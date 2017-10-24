<?php

namespace DMS\Service\Meetup\Exception;

use GuzzleHttp\Command\Exception\CommandClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ClientException extends \Exception
{
    /** @var  CommandClientException */
    protected $previous;

    public static function fromGuzzleException(CommandClientException $exception): self
    {
        $instance = new static($exception->getMessage(), $exception->getResponse()->getStatusCode());
        $instance->previous = $exception;
        return $instance;
    }

    public function getRequest(): RequestInterface
    {
        return $this->previous->getRequest();
    }

    public function getResponse(): ResponseInterface
    {
        return $this->previous->getResponse();
    }
}
