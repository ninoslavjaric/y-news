<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:42 AM
 */

namespace Bravo\Lib\Database;
use Bravo\Lib\Config;
use Bravo\Lib\Contracts\Cacheable;
use \Redis as RealRedis;

class Redis extends RealRedis implements Cacheable
{
    private static $params = [
        'host'  =>  "localhost",
        'port'  =>  3306,
    ];
    /**
     * @var static
     */
    private static $instance;

    /**
     * @return Redis
     */
    public static function getInstance(): Redis
    {
        if(!isset(self::$instance)){
            $params = Config::get("database.redis");

            $params =   array_merge(self::$params, $params);
            $redis = new self;

            $redis->connect($params['host'], $params['port']);
            if(isset($params['dbname']))
                $redis->select($params['dbname']);
            self::$instance = $redis;
        }
        return self::$instance;
    }

    public function getItem($key): string
    {
        return $this->get($key);
    }

    public function setItem($key, $value): Cacheable
    {
        $this->set($key, $value);
        return $this;
    }

    public function removeItem($key): Cacheable
    {
        $this->del($key);
        return $this;
    }
}