<?php

namespace DMS\Tools\Meetup\Helper;

use DMS\Tools\Meetup\ValueObject\Api;

class DuplicateResolver
{
    /**
     * @param Api[] $apis
     */
    public static function processApis($apis)
    {
        self::compare($apis[3], $apis['stream']);
        self::compare($apis[3], $apis[1]);
        self::compare($apis[3], $apis[2]);
    }

    /**
     * @param Api $mainApi
     * @param Api $secondaryApi
     */
    public static function compare($mainApi, $secondaryApi)
    {
        $x = $mainApi->extractMethodNames();
        $y = $secondaryApi->extractMethodNames();
        $overlap = array_intersect($mainApi->extractMethodNames(), $secondaryApi->extractMethodNames());

        foreach ($overlap as $key) {
            $secondaryApi->renameOperation($key, $key.'v'.$secondaryApi->apiVersion);
        }
    }
}
