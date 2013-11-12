<?php

namespace DMS\Service\Meetup\Response;

use Guzzle\Http\Message\Response;

class SelfParsingResponse extends Response
{

    /**
     * Data returned from Request
     *
     * @var array
     */
    protected $data;

    /**
     * Metadata returned by API
     *
     * @var array
     */
    protected $metadata;

    public function __construct($statusCode, $headers = null, $body = null)
    {
        parent::__construct($statusCode, $headers, $body);
        $this->parseMeetupApiData();
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Parses the Meetup Response based on content type.
     *
     * @return array
     */
    public function parseBodyContent()
    {
        if (strpos($this->getContentType(), 'json') === false) {
            parse_str($this->getBody(true), $array);

            return $array;
        }

        return $this->json();
    }

    /**
     * Makes Meetup API Data available on the Data attribute
     */
    public function parseMeetupApiData()
    {
        $responseBody = $this->parseBodyContent();
        $this->setData($responseBody);
    }

    /**
     * Returns true array representation of Response
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
