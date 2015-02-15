<?php

namespace DMS\Tools\Meetup;

class Api
{
    public $name;
    public $apiVersion;
    public $description;
    public $operations = array();

    public static function build($name, $version, $description)
    {
        $api = new static();
        $api->name = $name;
        $api->apiVersion = $version;
        $api->description = $description;

        return $api;
    }

    public function addOperation(Operation $operation)
    {
        $this->operations[] = $operation;
    }

    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
