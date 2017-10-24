<?php

namespace DMS\Service\Meetup\Exception;

final class MissingPackageException extends \Exception
{
    public static function forOAuth1(): self
    {
        return new static("Please install the guzzlehttp/oauth-subscriber package to use this Auth method");
    }
}
