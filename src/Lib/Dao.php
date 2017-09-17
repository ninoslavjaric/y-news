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
use Bravo\Lib\Traits\ContainerBehaviour;

/**
 * Class Dao
 * @package Bravo\Lib
 */
abstract class Dao
{
    use ContainerBehaviour;

    /**
     * @var string
     */
    public static $dtoType;
    /**
     * @var string
     */
    public static $table;

    /**
     * @var Instanceable
     */
    private static $adapter;

    protected function __construct()
    {}

    public function getDtoType(){
        return static::$dtoType;
    }
    public function getTable(){
        return static::$table;
    }

    /**
     * @return Storable
     */
    protected static function getAdapter(){
        if(!isset(self::$adapter))
            self::$adapter = Config::get("dao.adapter")::getInstance();
        return self::$adapter;
    }

    /**
     * @param null $orderKey
     * @param bool $direction
     * @param null $limit
     * @param int $offset
     * @return array
     */
    public function getAll($orderKey = null, $direction = true, $limit = null, $offset = 0): array {
        $storable = self::getAdapter()->select($this);
        if($orderKey)
            $storable = $storable->orderBy($orderKey, $direction);
        if($limit)
            $storable = $storable->limit($limit, $offset);
        return $storable->get();
    }
    /**
     * @param int $id
     * @return Dto
     * @throws \Exception
     */
    public function getById(int $id): Dto{
//        $class = get_class($this);
//        $result = self::getAdapter()
//            ->select($this)
//            ->where("id = ?", [$id])
//            ->get($class::$dtoType)
//        ;
//        if($result)
//            return current($result);
        if($dto = $this->getOneBy("id", $id))
            return $dto;
        throw new \Exception("No Dto with id = {$id}");
    }

    /**
     * @param string $column
     * @param $value
     * @param bool $like
     * @param string|null $orderKey
     * @param bool $direction
     * @return array
     */
    public function getBy(string $column, $value, bool $like = false, $orderKey = null, $direction = true, $limit = null, $offset = 0): array {
        $comparator = $like ? "LIKE" : "=";
        $value = $like ? "%{$value}%" : $value;
        $storable = self::getAdapter()
            ->select($this)
            ->where("`{$column}` {$comparator} ?", [$value])
        ;
        if($orderKey)
            $storable = $storable->orderBy($orderKey, $direction);
        if($limit)
            $storable = $storable->limit($limit, $offset);
        return $storable->get();
    }
    /**
     * @param string $column
     * @param $value
     * @param bool $like
     * @return Dto|null
     */
    public function getOneBy(string $column, $value, bool $like = false) {
        if($result = $this->getBy($column, $value, $like))
            return current($result);
        return null;
    }

    public function persist(Dto &$object){
        self::getAdapter()->insertOrUpdate($object);
    }

    /**
     * @return Dao
     */
    public static function getInstance(){
        if(isset(self::$container[static::class]))
            return self::$container[static::class];
        self::$container[static::class] = new static;
        return self::$container[static::class];
    }
}