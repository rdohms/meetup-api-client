<?php

namespace DMS\Service\Meetup\Config;

interface ClientConfig
{
    /**
     * @return callable[]
     */
    public function getMiddleware(): array;
}
