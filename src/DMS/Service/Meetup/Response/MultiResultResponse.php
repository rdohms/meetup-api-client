<?php

namespace DMS\Service\Meetup\Response;

use Guzzle\Http\Message\Response as BaseResponse;
use Traversable;

class MultiResultResponse extends BaseResponse implements \IteratorAggregate
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
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     *
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * Returns true array instance
     *
     * @return array
     */
    public function __toArray()
    {
        return $this->data;
    }
}
