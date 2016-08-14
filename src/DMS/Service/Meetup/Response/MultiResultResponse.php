<?php

namespace DMS\Service\Meetup\Response;

use Closure;
use Guzzle\Http\EntityBody;

class MultiResultResponse extends SelfParsingResponse implements \Countable, \Iterator
{
    /**
     * Makes Meetup API Data available on the Data attribute.
     */
    public function parseMeetupApiData()
    {
        $responseBody = $this->parseBodyContent();
        $this->setData($responseBody['results']);
        $this->setMetadata($responseBody['meta']);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object.
     *
     * @link http://php.net/manual/en/countable.count.php
     *
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
        $clone = clone $this;

        $clone->setData(array_map($func, $this->data));
        $clone->updateBody();

        return $clone;
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
        $clone = clone $this;

        $clone->setData(array_filter($this->data, $p));
        $clone->updateBody();

        return $clone;
    }

    /**
     * Assigns a new body to the request, based on the data it contains.
     */
    private function updateBody()
    {
        $data = array('meta' => $this->metadata, 'results' => $this->data);

        $this->body = EntityBody::factory(
            $this->isContentType('json') ? json_encode($data) : http_build_query($data)
        );
    }

    /**
     * Applies the given predicate p to all elements of this collection,
     * returning true, if the predicate yields true for all elements.
     *
     * @param Closure $p The predicate.
     *
     * @return bool TRUE, if the predicate yields TRUE for all elements, FALSE otherwise.
     */
    public function forAll(Closure $p)
    {
        foreach ($this->data as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element.
     *
     * @link http://php.net/manual/en/iterator.current.php
     *
     * @return mixed Can return any type.
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element.
     *
     * @link http://php.net/manual/en/iterator.next.php
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element.
     *
     * @link http://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid.
     *
     * @link http://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     */
    public function valid()
    {
        return false !== current($this->data);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element.
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->data);
    }
}
