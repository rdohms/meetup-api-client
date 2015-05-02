DMS Meetup.com API Client [![Build Status](https://travis-ci.org/rdohms/meetup-api-client.png?branch=master)](https://travis-ci.org/rdohms/meetup-api-client)
=========================

[en](https://github.com/rdohms/meetup-api-client/blob/master/README.md) | [pt_BR](https://github.com/rdohms/meetup-api-client/blob/master/README_pt_BR.md)

DMS Meetup.com API Client é um cliente para a API do Meetup.com construído com o Guzzle.

## Instalação

A biblioteca está disponível via Composer, por isso é fácil instalá-la. Apenas adicione-a ao seu arquivo `composer.json`:

    "require": {
        "dms/meetup-api-client": "~1.0"
    }
    
E execute `composer install`

## Recursos

* Todos os métodos documentados e não-obsoletos das APIs:
    * Meetup API v3
    * Meetup API v2 (urls /2/* e urls Everywhere /ew/)
    * Legacy v1, exceto os métodos marcados como obsoletos
* Autenticação por chave (key authentication)
* Autenticação OAuth 1.0
* Métodos POST, GET e DELETE

## Como utilizar
    
Para usar o API Client simplesmente instancie o cliente desejado (key auth ou OAuth), fornecendo os parâmetros adequados

```php
<?php

// Autenticação por chave (key authentication)
$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

// Autenticação OAuth
$config = array(
    'consumer_key'    => 'consumer-key',
    'consumer_secret' => '*****',
    'token'           => '*****',
    'token_secret'    => '*****',
);
$client = MeetupOAuthClient::factory($config);
```

Chame os *Commands* usando nosso método `__call` (phpDocs para auto-complete estão disponíveis)

```php
<?php 

$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

// Use nosso método __call (auto-complete fornecido)
$response = $client->getRsvps(array('event_id' => 'the-event-id'));

foreach ($response as $responseItem) {
    echo $responseItem['member']['name'] . PHP_EOL;
}
``` 
Ou use o método `getCommand`:

```php
<?php 

$client = MeetupKeyAuthClient::factory(array('key' => 'my-meetup-key'));

//Recuperando o Command do Guzzle
$command = $client->getCommand('GetRsvps', array('event_id' => 'the-event-id'));
$command->prepare();

$response = $command->execute();

foreach ($response as $responseItem) {
    echo $responseItem['member']['name'] . PHP_EOL;
}
```

## Resposta (Response)

Este wrapper implementa dois tipos de respostas personalizadas para facilitar a utilização dos resultados diretamente.

### Resposta para Coleções (Collections)

Quando está consultando coleções (collections), o cliente encapsula o resultado em um objeto `MultiResultResponse`. Essa resposta implementa um `Iterator`, permitindo a iteração direta pelo resultados, ao mesmo tempo que continua fornecendo acesso a todos os dados da resposta e também aos metadados retornados pela API usando o método `getMetaData()`.

```php
<?php

$rsvps = $client->getRsvps(array('event_id' => 'the-event-id'));

foreach ($rsvps as $rsvp) {
    echo $rsvp['member']['name'] . PHP_EOL;
}

$metadata = $response->getMetaData();
echo "Debug Url:" . $metadata['url'];
```

### Resposta para um Único Recurso (Single Resource)

Quando está buscando informação de um recurso único, o cliente irá encapsulá-la em um objeto `SingleResultResponse`. Essa resposta lhe dá acesso direto ao array dos resultados, mas não guarda os dados da resposta para que você pudesse continuar acessando-a.

```php
<?php

$rsvp = $client->getRsvp(array('id' => 'rsvp-id'));

echo "Rsvp? " . $rsvp['response'];

echo "StatusCode: " . $rsvp->getStatusCode();
```

## Licença

API Client está disponível sob uma Licença MIT.
