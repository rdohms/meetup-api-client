<?php

namespace DMS\Service\Meetup\Response;

use Guzzle\Common\Collection;

class MultiResultResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testSerialization()
    {
        $response = $this->createResponse();

        $serialized = serialize($response);

        $this->assertNotContains('data', $serialized);
        $this->assertNotContains('metadata', $serialized);

        $unserialized = unserialize($serialized);

        $this->assertEquals($response->getData(), $unserialized->getData());
        $this->assertEquals($response->getMetadata(), $unserialized->getMetadata());

        $this->assertInternalType('array', $unserialized->getData());
    }

    /**
     * @dataProvider filterData
     */
    public function testFilterShouldReturnANewFilteredInstance(\Closure $filter, array $expectedData)
    {
        $originalResponse = $this->createResponse();
        $response = $originalResponse->filter($filter);

        $this->assertNotSame($originalResponse, $response);
        $this->assertAttributeEquals($expectedData, 'data', $response);
    }

    /**
     * @dataProvider filterData
     */
    public function testSerializeAfterFilterShouldKeepTheNewData(\Closure $filter, array $expectedData)
    {
        $originalResponse = $this->createResponse();
        $response = $originalResponse->filter($filter);

        $response = unserialize(serialize($response));

        $this->assertAttributeEquals($expectedData, 'data', $response);
    }

    /**
     * @dataProvider mapData
     */
    public function testMapShouldReturnANewUpdatedInstance(\Closure $filter, array $expectedData)
    {
        $originalResponse = $this->createResponse();
        $response = $originalResponse->map($filter);

        $this->assertNotSame($originalResponse, $response);
        $this->assertAttributeEquals($expectedData, 'data', $response);
    }

    /**
     * @dataProvider mapData
     */
    public function testSerializeAfterMapShouldKeepTheNewData(\Closure $filter, array $expectedData)
    {
        $originalResponse = $this->createResponse();
        $response = $originalResponse->map($filter);

        $response = unserialize(serialize($response));

        $this->assertAttributeEquals($expectedData, 'data', $response);
    }

    /**
     * @return MultiResultResponse
     */
    private function createResponse()
    {
        $code = 200;
        $headers = new Collection(['Content-Type' => 'application/json']);

        $content = json_encode(
            [
                'meta'    => ['self' => 'me'],
                'results' => [
                    ['id' => 1],
                    ['id' => 2],
                    ['id' => 3],
                    ['id' => 4],
                ],
            ]
        );

        return new MultiResultResponse($code, $headers, $content);
    }

    public function filterData()
    {
        return [
            [
                function (array $item) {
                    return $item['id'] < 3;
                },
                [['id' => 1], ['id' => 2]],
            ],
        ];
    }

    public function mapData()
    {
        return [
            [
                function (array $item) {
                    $item['id'] *= 2;

                    return $item;
                },
                [
                    ['id' => 2],
                    ['id' => 4],
                    ['id' => 6],
                    ['id' => 8],
                ],
            ],
        ];
    }
}
