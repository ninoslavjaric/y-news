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
        $test = self::getAdapter()->select($this)->get($this->dtoType);
        return [];
    }

    /**
     * @param int $id
     * @return Dto
     */
    public function getById(int $id): Dto{
        return null;
    }

    /**
     * @param string $column
     * @param $value
     * @return Dto[]
     */
    public function getBy(string $column, $value): array {
        return null;
    }

}