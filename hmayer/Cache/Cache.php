<?php

namespace hmayer\Cache;

/**
 * Description of Cache
 *
 * @author mayer
 */
class Cache implements \hmayer\Cache\ICache
{
    private static $memcache = null;
    
    private static function loadConfig() {
        if (is_null(self::$memcache)) {
            self::$memcache = \hmayer\Config\Settings::getValue('memcache');
        }
    }

    public static function store(\hmayer\Query\Operator $operator, $number)
    {
        self::loadConfig();
        if (self::$memcache->enabled) {
            Memcache::store($operator, $number);
        } else {
            Fakecache::store($operator, $number);
        }
    }
    
    public static function load($number)
    {
       self::loadConfig();
       if (self::$memcache->enabled) {
            Memcache::load($number);
        } else {
            Fakecache::load($number);
        }
    }
}
