<?php

namespace DMS\Tools\Meetup\ValueObject;

final class ModelProperty
{
    /**
     * @var string
     */
    public $location;

    /**
     * @var string
     */
    public $type;

    /**
     * @param string $location
     */
    public function __construct(string $location)
    {
        $this->location = $location;
    }

    public static function withType(string $type, string $location): self
    {
        $instance = new static($location);
        $instance->type = $type;
        return $instance;
    }
}
