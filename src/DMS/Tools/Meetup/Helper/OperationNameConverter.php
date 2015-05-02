<?php

namespace DMS\Tools\Meetup\Helper;

use DMS\Tools\Meetup\ValueObject\Operation;

/**
 * Class OperationNameConverter
 *
 * @package DMS\Tools\Meetup
 */
class OperationNameConverter
{
    /**
     * Parse Operation name
     *
     * @param Operation $operation
     * @return string
     */
    public static function parseOperationName(Operation $operation)
    {
        $verb = self::deriveAction($operation->httpMethod, $operation->uri);

        $wordifiedPath = self::wordifyPath($operation->uri);

        if ($operation->version == 'stream') {
            $wordifiedPath = $wordifiedPath . 'Stream';
        }

        if (preg_match("/^\/{urlname}.*/", $operation->uri) == 1) {
            $wordifiedPath = 'Group' . $wordifiedPath;
        }

        return ucfirst($verb . $wordifiedPath);
    }

    /**
     * Converts the url parts into words
     *
     * @param string $path
     * @return string
     */
    public static function wordifyPath($path)
    {
        // drop parameters
        $path = preg_replace('/{[a-z_]*}/', '', $path);
        $path = preg_replace('/[0-9]*/', '', $path);
        $path = str_replace('_', '/', $path);

        // split
        $parts = array_filter(explode('/', $path));

        //UpperCase Words
        $parts = array_map('ucfirst', $parts);

        return implode('', $parts);
    }

    /**
     * Derives a Verb for the endpoint
     *
     * @param string $method
     * @param string $path
     * @return string
     */
    public static function deriveAction($method, $path)
    {
        $method = strtolower($method);

        if ($method == 'get') {
            return $method;
        }

        if ($method == 'delete') {
            return $method;
        }

        if ($method == 'post' && $path == '/{urlname}') {
            return 'edit';
        }

        if ($method == 'post' && (strpos($path, '{id}') !== false || strpos($path, '{mid}') !== false)) {
            return 'edit';
        }

        if ($method == 'post') {
            return 'create';
        }

        if ($method == 'ws') {
            return 'webSocket';
        }

        return '';
    }
}
