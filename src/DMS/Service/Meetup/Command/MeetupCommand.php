<?php

namespace DMS\Service\Meetup\Command;

use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseParserInterface;

/**
 * Class MeetupCommand
 *
 * Custom Command Class that allows us to parse into
 * custom Responses
 *
 * @package DMS\Service\Meetup\Command
 */
class MeetupCommand extends OperationCommand
{
    /**
     * {@inheritdoc}
     *
     * @return MeetupResponseParser|ResponseParserInterface
     */
    public function getResponseParser()
    {
        if ( ! $this->responseParser) {
            $this->responseParser = MeetupResponseParser::getInstance();
        }

        return $this->responseParser;
    }
}
