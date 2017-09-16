<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 3:05 PM
 */

namespace Bravo\Lib;


use Bravo\Lib\Contracts\Cacheable;

final class Cache
{
    private static $adapter;

    /**
     * @return Cacheable
     */
    private static function getAdapter():Cacheable{
        if(!isset(self::$adapter))
            self::$adapter = Config::get("cache.adapter")::getInstance();
        return self::$adapter;
    }

    /**
     * @param $key
     * @return string
     */
    public static function get($key) {
        if($result = self::getAdapter()->getItem($key))
            return unserialize($result);
        return null;
    }

    /**
     * @param $key
     * @param $value
     * @return Cacheable
     */
    public static function set($key, $value){
        return self::getAdapter()->setItem($key, serialize($value));
    }

    /**
     * @param $key
     * @return Cacheable
     */
    public static function del($key){
        return self::getAdapter()->removeItem($key);
    }
}