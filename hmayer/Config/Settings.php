<?php

namespace hmayer\Config;

/**
 * Settings, just this
 *
 * @author mayer
 */
class Settings
{

    private static $data = null;

    private static function handleJsonFile($filename)
    {
        self::$data = json_decode(file_get_contents($filename));
    }

    public static function load($filename, $type = "json")
    {
        switch ($type) {
            CASE 'json':
                self::handleJsonFile($filename);
                break;
            default:
                break;
        }
    }

    public static function getValue($key)
    {
        if (array_key_exists($key, self::$data)) {
            return self::$data->{$key};
        } else {
            return false;
        }
    }

}
