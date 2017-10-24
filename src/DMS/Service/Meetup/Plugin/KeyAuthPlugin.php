<?php

namespace DMS\Service\Meetup\Plugin;

use Psr\Http\Message\RequestInterface;

final class KeyAuthPlugin
{
    /**
     * @var string
     */
    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __invoke(RequestInterface $request): RequestInterface
    {
        $uri = $request->getUri();
        $uri = $uri->withQuery($uri->getQuery() . '&key=' . $this->key);

        return $request->withUri($uri);
    }
}
