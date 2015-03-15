<?php

namespace DMS\Tools\Meetup;

use DMS\Tools\ArrayHelper as a;

class Operation
{
    public $version;
    public $name;
    public $httpMethod;
    public $parameters = array();
    public $summary;
    public $uri;
    public $notes;

    /**
     * @param $definition
     * @return static
     */
    public static function createFromApiJsonDocs($definition)
    {
        if (a::read($definition, 'group') == 'deprecated') {
            return null;
        }

        $operation = new static();

        $operation->version = (a::read($definition, 'group') == 'streams')
            ? 'stream'
            : a::read($definition, 'api_version', '1');

        $operation->httpMethod = a::read($definition, 'http_method');
        $operation->summary = a::read($definition, 'desc');
        $operation->notes  = a::read($definition, 'param_notes');
        $operation->parsePath(a::read($definition, 'path'));

        foreach (a::read($definition, 'params', array()) as $param => $desc) {
            // Always false due to complex rules on meetup's side (one of x is required)
            $operation->addParameter(str_replace('*', '', $param), 'query', false, $desc);
        }

        foreach (a::read($definition, 'orders', array()) as $param => $desc) {
            $operation->addParameter($param, 'query', false, $desc);
        }

        $operation->addStandardParameters(a::read($definition, 'http_method'));

        $operation->name = OperationNameConverter::parseOperationName($operation);

        return $operation;
    }

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

    protected function addParameter($name, $location, $required, $description = null)
    {
        if (strpos($name, ',') !== false) {

            foreach (explode(',', $name) as $subname) {
                $this->addParameter($subname, $location, $required, $description);
            }

            return;
        }


        $this->parameters[$name] = Parameter::build($location, $required, $description);
    }

    public function toJson()
    {
        return '';
    }
}
