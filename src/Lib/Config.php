<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 3:02 PM
 */

namespace Bravo\Lib;


class Config
{
    private static $params = [];

    public static function get(string $path){
        $path = explode(".", $path);
        $param = static::$params;
        foreach ($path as $key => $item){
            if(isset($param[$item]))
                $param = $param[$item];
            else
                return null;
        }
        return $param;
    }
    public static function init(array $params){
        self::$params = $params;
    }
}