<?php

namespace DMS\Tools\Meetup\ValueObject;

final class Model
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $properties = [];

    /**
     * @var string
     */
    public $location;

    /**
     * @var Model
     */
    public $items = null;

    public static function createFromConfig(array $response, bool $isList): self
    {
        $instance = ($isList)? static::createForList($response) : static::createForSimpleResource($response);
        return $instance;
    }

    private static function createForList(array $response): self
    {
        $instance = new static();
        $instance->type = 'array';
        $instance->items = Model::createFromConfig($response, false);
        $instance->location = 'json';

        return $instance;
    }

    private static function createForSimpleResource(array $response): self
    {
        $instance = new static();
        $instance->type = 'object';

        foreach ($response as $name => $value) {
            $property = (\is_array($value))
                ? ModelProperty::withType('object', 'json')
                : new ModelProperty('json');

            $instance->addProperty($name, $property);
        }

        $instance->addProperty('status', ModelProperty::withType('integer', 'statusCode'));

        return $instance;
    }

    private function addProperty(string $name, ModelProperty $property): void
    {
        $this->properties[$name] = $property;
    }
}
