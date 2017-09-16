<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/16/17
 * Time: 9:47 PM
 */

namespace Bravo\Lib\Traits;


use Bravo\Lib\Dao;
use Bravo\Lib\Dto;

trait ContainerBehaviour
{
    private static $container = [];

    /**
     * @return array
     */
    final public static function getObjects(){
        return self::$container;
    }
    /**
     * @param $key
     * @return Dao|Dto|null
     */
    final public static function getObject($key){
        if(isset(self::$container[$key]))
            return self::$container[$key];
        return null;
    }

    /**
     * @param string $key
     * @param $object
     */
    final public static function addObject(string $key, $object){
        self::$container[$key] = $object;
    }
}