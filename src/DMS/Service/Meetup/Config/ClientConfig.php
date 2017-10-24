<?php

namespace DMS\Service\Meetup\Config;

interface ClientConfig
{
    /**
     * @return callable[]
     */
    public function getMiddleware(): array;

    /**
     * @return string[]
     */
    public function getClientConfig(): array;
}
