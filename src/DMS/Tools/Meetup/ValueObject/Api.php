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
    public $operations = [];

    /**
     * @var array
     */
    public $models = [];

    /**
     * Build a new API Object.
     *
     * @param string $name
     * @param string $version
     * @param string $description
     *
     * @return static
     */
    public static function build($name, $version, $description)
    {
        $api = new static();
        $api->name = $name;
        $api->apiVersion = $version;
        $api->description = $description;

        return $api;
    }

    /**
     * Adds a new operation.
     *
     * @param Operation $operation
     */
    public function addOperation(Operation $operation)
    {
        $this->operations[$operation->name] = $operation;
        ksort($this->operations);

        $this->addModelFromOperation($operation);
    }

    private function addModelFromOperation(Operation $operation): void
    {
        $model = ($operation->response !== null)
            ? Model::createFromConfig($operation->response, $operation->hasListResult())
            : new SimpleModel();

        $this->models[$operation->name] = $model;
        ksort($this->models);
    }

    /**
     * @param $oldName
     * @param $newName
     */
    public function renameOperation($oldName, $newName)
    {
        $this->operations[$oldName]->name = $newName;
        $this->operations[$newName] = $this->operations[$oldName];

        unset($this->operations[$oldName]);
    }

    /**
     * Outputs Guzzle Json structure.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param string $name
     *
     * @return Operation
     */
    public function getOperation($name)
    {
        return $this->operations[$name];
    }

    /**
     * @return array
     */
    public function extractMethodNames()
    {
        return array_keys($this->operations);
    }
}
