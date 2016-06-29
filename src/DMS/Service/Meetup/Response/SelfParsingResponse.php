<?php

namespace DMS\Service\Meetup\Response;

use Guzzle\Http\Message\Response;

class SelfParsingResponse extends Response
{
    /**
     * Data returned from Request.
     *
     * @var array
     */
    protected $data;

    public function __construct($statusCode, $headers = null, $body = null)
    {
        parent::__construct($statusCode, $headers, $body);
        $this->parseMeetupApiData();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Parses the Meetup Response based on content type.
     *
     * @return array
     */
    protected function parseBodyContent()
    {
        if (!$this->isContentType('json')) {
            parse_str($this->getBody(true), $array);

            return $array;
        }

        return $this->json();
    }

    /**
     * Makes Meetup API Data available on the Data attribute.
     */
    protected function parseMeetupApiData()
    {
        $this->data = $this->parseBodyContent();
    }

    /**
     * Returns true array representation of Response.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
