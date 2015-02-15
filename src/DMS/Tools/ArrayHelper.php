<?php

namespace DMS\Tools;

class ArrayHelper
{
    public static function read($array, $key, $default = null)
    {
        if (! isset($array[$key])) {
            return $default;
        }

        return $array[$key];
    }
}
