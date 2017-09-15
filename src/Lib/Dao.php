<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:23 AM
 */

namespace Bravo\Lib;


use Bravo\Lib\Contracts\Instanceable;
use Bravo\Lib\Contracts\Storable;

/**
 * Class Dao
 * @package Bravo\Lib
 * @property string $table
 * @property string dtoType
 */
abstract class Dao
{
    /**
     * @var Instanceable
     */
    private static $adapter;
    /**
     * @return Storable
     */
    protected static function getAdapter(){
        if(!isset(self::$adapter))
            self::$adapter = Config::get("dao.adapter")::getInstance();
        return self::$adapter;
    }
    /**
     * @return Dto[]
     */
    public function getAll(): array {
        return self::getAdapter()
            ->select($this)
            ->get($this->dtoType)
        ;
    }
    /**
     * @param int $id
     * @return Dto
     * @throws \Exception
     */
    public function getById(int $id): Dto{
        $result = self::getAdapter()
            ->select($this)
            ->where("id = {$id}")
            ->get($this->dtoType)
        ;
        if($result)
            return current($result);
        throw new \Exception("No Dto with id = {$id}");
    }
    /**
     * @param string $column
     * @param $value
     * @param bool $like
     * @return array
     */
    public function getBy(string $column, $value, bool $like = false): array {
        $comparator = $like ? "LIKE" : "=";
        $value = $like ? "%{$value}%" : $value;
        return self::getAdapter()
            ->select($this)
            ->where("{$column} {$comparator} '{$value}'")
            ->get($this->dtoType)
        ;
    }
}