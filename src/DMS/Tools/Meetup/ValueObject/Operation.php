<?php

namespace DMS\Tools\Meetup\ValueObject;

use DMS\Tools\Meetup\Helper\OperationNameConverter;
use DMS\Tools\Meetup\ValueObject\Parameter;
use MathiasGrimm\ArrayPath\ArrayPath as arr;

/**
 * Class Operation
 */
class Operation
{
    /**
     * @var string
     */
    public $version;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $httpMethod;

    /**
     * @var array
     */
    public $parameters = array();

    /**
     * @var string
     */
    public $summary;

    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $notes;

    /**
     * @param $definition
     * @return static
     */
    public static function createFromApiJsonDocs($definition)
    {
        if (arr::get('group', $definition) == 'deprecated') {
            return null;
        }

        $operation = new static();

        $operation->version = (arr::get('group', $definition) == 'streams')
            ? 'stream'
            : arr::get('api_version', $definition, '1');

        $operation->httpMethod = arr::get('http_method', $definition);
        $operation->summary    = arr::get('desc', $definition);
        $operation->notes      = arr::get('param_notes', $definition);
        $operation->parsePath(arr::get('path', $definition));

        foreach (arr::get('params', $definition, array()) as $param => $desc) {
            // Always false due to complex rules on meetup's side (one of x is required)
            $operation->addParameter(str_replace('*', '', $param), 'query', false, $desc);
        }

        foreach (arr::get('orders', $definition, array()) as $param => $desc) {
            $operation->addParameter($param, 'query', false, $desc);
        }

        $operation->addStandardParameters(arr::get('http_method', $definition));

        $operation->name = OperationNameConverter::parseOperationName($operation);

        return $operation;
    }

    /**
     * Add default parameters
     *
     * @param string $httpMethod
     */
    protected function addStandardParameters($httpMethod)
    {
        if ($httpMethod != 'GET') {
            return;
        }

        $this->addParameter('page', 'query', false);
        $this->addParameter('offset', 'query', false);
        $this->addParameter('desc', 'query', false);
        $this->addParameter('order', 'query', false);
        $this->addParameter('only', 'query', false);
        $this->addParameter('omit', 'query', false);
    }

    /**
     * Parse Parameters from Path
     * @param string $path
     */
    protected function parsePath($path)
    {
        $uriParams       = array();
        $uriParamsCount  = preg_match_all("/(:[^\/]*)/", $path, $uriParams);
        $translateParams = array();

        foreach ($uriParams[0] as $rawParam) {
            $param = str_replace(':', '', $rawParam);
            $this->addParameter($param, 'uri', true);

            $translateParams[$rawParam] = "{" . $param . "}";
        }

        $this->uri = strtr($path, $translateParams);
    }

    /**
     * Add a new parameter to definition
     *
     * @param string $name
     * @param string $location
     * @param boolean $required
     * @param string|null $description
     */
    protected function addParameter($name, $location, $required, $description = null)
    {
        $name = trim($name);

        if (strpos($name, ',') !== false) {

            foreach (explode(',', $name) as $subname) {
                $this->addParameter($subname, $location, $required, $description);
            }

            return;
        }

        $this->parameters[$name] = Parameter::build($location, $required, $description);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return '';
    }
}
