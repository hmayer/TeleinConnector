<?php

namespace hmayer\Cache;

/**
 *
 * @author mayer
 */
interface ICache
{
public static function store(\hmayer\Query\Operator $operator, $number);
public static function load($number);
}
