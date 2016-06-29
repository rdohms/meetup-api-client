<?php

namespace DMS\Service\Meetup\Response;

use ArrayIterator;
use Closure;
use Guzzle\Http\EntityBody;

class MultiResultResponse extends SelfParsingResponse implements \Countable, \IteratorAggregate
{
    /**
     * Metadata returned by API.
     *
     * @var array
     */
    private $metadata;

    /**
     * Makes Meetup API Data available on the Data attribute.
     */
    protected function parseMeetupApiData()
    {
        $responseBody = $this->parseBodyContent();

        $this->data = $responseBody['results'];
        $this->metadata = $responseBody['meta'];
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

        $clone->data = array_map($func, $this->data);
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

        $clone->data = array_filter($this->data, $p);
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
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}
