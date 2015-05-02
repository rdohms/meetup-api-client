<?php

namespace DMS\Tools\Meetup\ValueObject;

class Api
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $apiVersion;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $operations = array();

    /**
     * Build a new API Object
     *
     * @param string $name
     * @param string $version
     * @param string $description
     * @return static
     */
    public static function build($name, $version, $description)
    {
        $api              = new static();
        $api->name        = $name;
        $api->apiVersion  = $version;
        $api->description = $description;

        return $api;
    }

    /**
     * Adds a new operation
     *
     * @param Operation $operation
     */
    public function addOperation(Operation $operation)
    {
        $this->operations[$operation->name] = $operation;
        ksort($this->operations);
    }

    /**
     * Outputs Guzzle Json structure
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
