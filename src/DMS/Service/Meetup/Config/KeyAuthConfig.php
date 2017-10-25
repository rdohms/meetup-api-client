<?php

namespace DMS\Service\Meetup\Config;

use DMS\Service\Meetup\Plugin\KeyAuthPlugin;

final class KeyAuthConfig implements ClientConfig
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getMiddleware(): array
    {
        return [
            'add key' => Middleware::mapRequest(new KeyAuthPlugin($this->key))
        ];
    }

    /**
     * @return string[]
     */
    public function getClientConfig(): array
    {
        return [];
    }
}
