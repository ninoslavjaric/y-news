<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:42 AM
 */

namespace Bravo\Lib\Database;
use \Redis as RealRedis;

class Redis extends RealRedis implements Initializable
{
    private static $params = [
        'host'  =>  "localhost",
        'port'  =>  3306,
    ];
    public static function getInstance(array $params): Initializable
    {
        $params =   array_merge(self::$params, $params);
        $redis = new RealRedis;
        $redis->connect($params['host'], $params['port']);
        if(isset($params['dbname']))
            $redis->select($params['dbname']);
    }
}