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

    private static function getAdapter():Cacheable{
        if(!isset(self::$adapter))
            self::$adapter = Config::get("cache.adapter")::getInstance();
        return self::$adapter;
    }

    public static function get($key):string {
        return "123";
    }
    public static function set($key, $value){
        self::getAdapter()->set($key,$value);
    }
    public static function del($key){

    }
}