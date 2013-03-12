DMS Meetup.com API Client
=========================

This is a client for the Meetup.com API powered by the Guzzle Project.

## Installation

The library is available through Composer, so its easy to get it. Simply add this to your `composer.json` file:

    "require": {
        "dms/meetup-api-client": "~1.0@dev"
    }
    
And run `composer install`

## Features

* All documented and non-deprecated methods from:
    * Meetup Everywhere API
    * Meetup API v2 (/2/* urls)
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

foreach ($response['results'] as $responseItem) {
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

foreach ($response['results'] as $responseItem) {
    echo $responseItem['member']['name'] . PHP_EOL;
}
```
## License

The API client is available under an MIT License.