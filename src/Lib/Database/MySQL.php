<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:45 AM
 */

namespace Bravo\Lib\Database;


use Bravo\Lib\Config;
use Bravo\Lib\Contracts\Instanceable;

class MySQL extends \mysqli implements Instanceable
{
    private static $params = [
        'host'  =>  "localhost",
        'port'  =>  3306,
        'username'  =>  "root",
        'password'  =>  "",
    ];
    /**
     * @var static
     */
    private static $instance;

    /**
     * @return Instanceable
     */
    public static function getInstance(): Instanceable
    {
        if(!isset(self::$instance)){
            $params = Config::get("database.mysql");
            $params =   array_merge(self::$params, $params);
            self::$instance = new self(
                $params['host'],
                $params['username'],
                $params['password'],
                $params['dbname'],
                $params['port']
            );
        }
        return self::$instance;
    }
}