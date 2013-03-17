<?php

namespace DMS\Service\Meetup\Response;

use Closure;
use Guzzle\Http\Message\Response as BaseResponse;
use Traversable;

class MultiResultResponse extends BaseResponse implements \IteratorAggregate, \Countable
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
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Applies the given function to each element in the collection and returns
     * a new collection with the elements returned by the function.
     *
     * @param Closure $func
     *
     * @return MultiResultResponse
     */
    public function map(Closure $func)
    {
        return new static(array_map($func, $this->data));
    }

    /**
     * Returns all the elements of this collection that satisfy the predicate p.
     * The order of the elements is preserved.
     *
     * @param Closure $p The predicate used for filtering.
     *
     * @return MultiResultResponse A collection with the results of the filter operation.
     */
    public function filter(Closure $p)
    {
        return new static(array_filter($this->data, $p));
    }
    /**
     * Applies the given predicate p to all elements of this collection,
     * returning true, if the predicate yields true for all elements.
     *
     * @param Closure $p The predicate.
     *
     * @return boolean TRUE, if the predicate yields TRUE for all elements, FALSE otherwise.
     */
    public function forAll(Closure $p)
    {
        foreach ($this->data as $key => $element) {
            if ( ! $p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns true array instance
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
