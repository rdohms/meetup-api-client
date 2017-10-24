<?php

namespace DMS\Service\Meetup\Config;

use kamermans\OAuth2\GrantType\GrantTypeInterface;
use kamermans\OAuth2\OAuth2Middleware;

final class OAuth2Config implements ClientConfig
{
    /**
     * @var GrantTypeInterface
     */
    protected $grantType;

    /**
     * @var bool
     */
    protected $shouldSignAllRequests;

    /**
     * @param GrantTypeInterface $grantType
     * @param bool               $shouldSignAllRequests
     */
    public function __construct(GrantTypeInterface $grantType, bool $shouldSignAllRequests = true)
    {
        $this->grantType             = $grantType;
        $this->shouldSignAllRequests = $shouldSignAllRequests;
    }

    /**
     * @return callable[]
     */
    public function getMiddleware(): array
    {
        return [
            'oauth2' => new OAuth2Middleware($this->grantType)
        ];
    }

    /**
     * @return string[]
     */
    public function getClientConfig(): array
    {
        $config = [];

        if ($this->shouldSignAllRequests) {
            $config['auth'] = 'oauth';
        }

        return $config;
    }
}
