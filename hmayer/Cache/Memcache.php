<?php

namespace hmayer\Cache;

/**
 * Memcache
 *
 * @author mayer
 */
class Memcache implements \hmayer\Cache\ICache
{

    private static $memcache = null;
    private static $config = null;

    private static function loadMemcache()
    {
        if (is_null(self::$memcache)) {
            self::$memcache = new \Memcache();
            self::$config = \hmayer\Config\Settings::getValue('memcache');
            self::$memcache->pconnect(self::$config->host, self::$config->port);
        }
    }

    public static function store(\hmayer\Query\Operator $operator, $number)
    {
        self::loadMemcache();
        return self::$memcache->set(self::$config->prefix . $number,
                $operator,
                MEMCACHE_COMPRESSED,
                self::$config->expire);
    }
    
    public static function load($number) {
        self::loadMemcache();
        $operator = self::$memcache->get(self::$config->prefix . $number);
        return $operator;
    }
}
