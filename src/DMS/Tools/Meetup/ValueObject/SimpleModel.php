<?php

namespace DMS\Tools\Meetup\ValueObject;

final class SimpleModel
{
    /**
     * @var string
     */
    public $type = 'object';

    /**
     * @var array
     */
    public $properties = [];

    /**
     */
    public function __construct()
    {
        $this->properties['status'] = ModelProperty::withType('integer', 'statusCode');
    }

}
