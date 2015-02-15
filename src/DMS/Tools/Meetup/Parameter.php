<?php

namespace DMS\Tools\Meetup;

class Parameter
{
    const LOCATION_QUERY = 'query';
    const LOCATION_URI   = 'uri';

    public $location;
    public $required;
    public $description;

    public static function build($location, $required, $description)
    {
        $param = new static();
        $param->location = $location;
        $param->required = $required;
        $param->description = $description;

        return $param;
    }
}
