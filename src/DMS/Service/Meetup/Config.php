<?php

namespace DMS\Service\Meetup;

final class Config
{
    protected $descriptionPath;

    /**
     * @param $descriptionPath
     */
    public function __construct($descriptionPath)
    {
        $this->descriptionPath = $descriptionPath;
    }

}
