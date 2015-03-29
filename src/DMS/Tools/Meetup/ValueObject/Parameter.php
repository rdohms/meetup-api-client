<?php

namespace DMS\Tools\Meetup\ValueObject;

/**
 * Class Parameter
 */
class Parameter
{
    const LOCATION_QUERY = 'query';
    const LOCATION_URI   = 'uri';

    /**
     * @var string
     */
    public $location;

    /**
     * @var boolean
     */
    public $required = false;

    /**
     * @var string
     */
    public $description;

    /**
     * @param string $location
     * @param bool $required
     * @param string $description
     * @return static
     */
    public static function build($location, $required, $description)
    {
        $param = new static();
        $param->location = $location;
        $param->required = $required;
        $param->description = $description;

        return $param;
    }
}
