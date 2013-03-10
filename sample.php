<?php

use DMS\Service\Meetup\MeetupKeyAuthClient;
use DMS\Service\Meetup\MeetupOAuthClient;

include "vendor/autoload.php";

$client = MeetupKeyAuthClient::factory(array('key' => '54855707c254f3f793214051c437a'));

//$config = array(
//    'consumer_key'    => '3dkqagvsnop0c5bm9m7cfolv6v',
//    'consumer_secret' => '67u3cajgchaporfruqch7skric',
//);
//$client = MeetupOAuthClient::factory($config);

$command = $client->getCommand('RSVPsv2', array('event_id' => 'qnrswcyrdbcc'));
$command->prepare();
var_dump($command->getRequest()->getUrl());
//$response = $command->execute();

$response = $client->rSVPsv2(array('event_id' => 'qnrswcyrdbcc'));

foreach ($response['results'] as $responseItem) {
    var_dump($responseItem['member']['name']);
}
