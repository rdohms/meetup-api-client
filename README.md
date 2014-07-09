DMS Meetup.com API Client [![Build Status](https://travis-ci.org/rdohms/meetup-api-client.png?branch=master)](https://travis-ci.org/rdohms/meetup-api-client)
=========================

[en](https://github.com/rdohms/meetup-api-client/blob/master/README.md) | [pt_BR](https://github.com/rdohms/meetup-api-client/blob/master/README_pt_BR.md)

This is a client for the Meetup.com API powered by the Guzzle Project.

## Installation

The library is available through Composer, so its easy to get it. Simply add this to your `composer.json` file:

    "require": {
        "dms/meetup-api-client": "~1.0"
    }
    
And run `composer install`

## Features

* All documented and non-deprecated methods from:
    * Meetup API v3
    * Meetup API v2 (/2/* urls and Everywhere /ew/ urls)
    * Legacy v1, except methods tagged as deprecated
* Key authentication
* OAuth 1.0 Authetication
* POST, GET and DELETE methods

## Usage
    
To use the API Client simply instantiate the preferred client (key auth or OAuth), giving it the correct parameters

```php
<?php

// Key Authentication
$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

// OAuth Authentication
$config = array(
    'consumer_key'    => 'consumer-key',
    'consumer_secret' => '*****',
    'token'           => '*****',
    'token_secret'    => '*****',
);
$client = MeetupOAuthClient::factory($config);
```

Invoke Commands using our `__call` method (auto-complete phpDocs are included)

```php
<?php 

$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

// Use our __call method (auto-complete provided)
$response = $client->getRSVPs(array('event_id' => 'the-event-id'));

foreach ($response as $responseItem) {
    echo $responseItem['member']['name'] . PHP_EOL;
}
``` 
Or Use the `getCommand` method:

```php
<?php 

$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

//Retrieve the Command from Guzzle
$command = $client->getCommand('GetRSVPs', array('event_id' => 'the-event-id'));
$command->prepare();

$response = $command->execute();

foreach ($response as $responseItem) {
    echo $responseItem['member']['name'] . PHP_EOL;
}
```

## Response

This wrapper implements two types of custom responses to facilitate the usage of the results directly.

### Response for Collection

When querying for collections the client wraps the result in a `MultiResultResponse`. This response implements a `Iterator` allowing you to directly iterate over the results, while still giving you access to all response data, as well as the metadata returned by the API using the `getMetaData()` method.

```php
<?php

$rsvps = $client->getRSVPs(array('event_id' => 'the-event-id'));

foreach ($rsvps as $rsvp) {
    echo $rsvp['member']['name'] . PHP_EOL;
}

$metadata = $response->getMetaData();
echo "Debug Url:" . $metadata['url'];
```

### Response for Single Resource

When getting information of a single resource the client will wrap that in a `SingleResultResponse`. This response gives you direct array access to results, but retains response data so you can still access it.

```php
<?php

$rsvp = $client->getRSVP(array('id' => 'rsvp-id'));

echo "RSVP? " . $rsvp['response'];

echo "StatusCode: " . $rsvp->getStatusCode();
```

## License

The API client is available under an MIT License.
