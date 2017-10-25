<?php

namespace DMS\Service\Meetup\Config;

use DMS\Service\Meetup\Exception\MissingPackageException;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

final class OAuth1Config implements ClientConfig
{
    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $tokenSecret;

    /**
     * @var string
     */
    private $privateKeyFile;

    /**
     * @var string
     */
    private $privateKeyPassphrase;

    /**
     * @var string
     */
    private $signatureMethod;

    /**
     * @var bool
     */
    private $shouldSignAllRequests = true;

    private function __construct(string $consumerKey, string $consumerSecret, bool $shouldSignAllRequests = true)
    {
        if (!class_exists(Oauth1::class)) {
            MissingPackageException::forOAuth1();
        }

        $this->consumerKey           = $consumerKey;
        $this->consumerSecret        = $consumerSecret;
        $this->shouldSignAllRequests = $shouldSignAllRequests;
    }

    public static function withTwoLeggedOauth(
        string $consumerKey,
        string $consumerSecret,
        bool $shouldSignAllRequests = true
    ): self {
        $instance              = new static($consumerKey, $consumerSecret, $shouldSignAllRequests);
        $instance->tokenSecret = false;
        return $instance;
    }

    public static function withToken(
        string $consumerKey,
        string $consumerSecret,
        string $token,
        string $tokenSecret,
        bool $shouldSignAllRequests = true

    ): self {
        $instance              = new static($consumerKey, $consumerSecret, $shouldSignAllRequests);
        $instance->token       = $token;
        $instance->tokenSecret = $tokenSecret;
        return $instance;
    }

    public static function withRSASH1(
        string $consumerKey,
        string $consumerSecret,
        string $privateKeyFile,
        string $privateKeyPassphrase,
        bool $shouldSignAllRequests = true
    ): self {
        $instance                       = new static($consumerKey, $consumerSecret, $shouldSignAllRequests);
        $instance->privateKeyFile       = $privateKeyFile;
        $instance->privateKeyPassphrase = $privateKeyPassphrase;
        $instance->signatureMethod      = Oauth1::SIGNATURE_METHOD_RSA;
        return $instance;
    }

    /**
     * @return callable[]
     */
    public function getMiddleware(): array
    {
        return [
            'OAuth1' => new Oauth1($this->buildConfig()),
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

    private function buildConfig(): array
    {
        $config = [
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
        ];

        if ($this->signatureMethod !== null) {
            $config['signature_method'] = $this->signatureMethod;
        }

        if ($this->signatureMethod === Oauth1::SIGNATURE_METHOD_RSA) {
            $config['private_key_file']       = $this->privateKeyFile;
            $config['private_key_passphrase'] = $this->privateKeyPassphrase;
        }

        if ($this->token !== null) {
            $config['token'] = $this->token;
        }

        if ($this->tokenSecret !== null) {
            $config['token_secret'] = $this->tokenSecret;
        }

        return $config;
    }
}
