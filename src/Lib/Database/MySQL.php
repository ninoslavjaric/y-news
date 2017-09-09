<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:45 AM
 */

namespace Bravo\Lib\Database;


class MySQL extends \mysqli implements Initializable
{
    private static $params = [
        'host'  =>  "localhost",
        'port'  =>  3306,
        'username'  =>  "root",
        'password'  =>  "",
    ];

    /**
     * @param array $params
     * @return Initializable
     */
    public static function getInstance(array $params): Initializable
    {
        $params =   array_merge(self::$params, $params);
        return new self(
            $params['host'],
            $params['username'],
            $params['password'],
            $params['dbname'],
            $params['port']
        );
    }
}