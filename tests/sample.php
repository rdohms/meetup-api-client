<?php

use GuzzleHttp\Command\ResultInterface;
use GuzzleHttp\Promise\PromiseInterface;

include_once 'bootstrap.php';

$client = \DMS\Service\Meetup\ClientFactory::buildClient();


$command = $client->getCommand('GetGroup', ['urlname' => 'amsterdamphp']);

var_dump($command);

/** @var ResultInterface|PromiseInterface $result */
$result = $client->getGroup(['urlname' => 'amsterdamphp']);
//$result = $client->getFindVenues(['text' => 'amsterdam']);

var_dump($result);
var_dump($result->count());

var_dump($result->toArray());
