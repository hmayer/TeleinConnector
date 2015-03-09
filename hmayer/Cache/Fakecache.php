<?php

namespace hmayer\Cache;

/**
 * Fakecache implements ICache interface but don't make a cache really.
 * It's used when you don't have any cache server/module
 *
 * @author mayer
 */
class Fakecache implements \hmayer\Cache\ICache
{

    private static $operator = array();

    public static function store(\hmayer\Query\Operator $operator, $number)
    {
        self::$operator[$number] = $operator;
    }

    public static function load($number)
    {
        if (array_key_exists($number, self::$operator)) {
            return self::$operator[$number];
        } else {
            return false;
        }
    }

}
