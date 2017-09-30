<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:23 AM
 */

namespace Bravo\Lib;


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
     * @var Storable
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
     * @return int
     */
    public function getCountAll(): int {
        return self::getAdapter()
            ->select($this)
            ->count();
    }
    /**
     * @param int $id
     * @return Dto
     * @throws \Exception
     */
    public function getById(int $id): Dto{
        /** @var Dto $dto */
        if($dto = Cache::get("{$this->getDtoType()}:id:{$id}"))
            return $dto;
        if($dto = $this->getOneBy("id", $id))
            return $dto;
        throw new \Exception("No Dto with id = {$id}");
    }

    /**
     * @param mixed $column
     * @param $value
     * @param bool $like
     * @return Storable
     * @throws \Exception
     */
    private function prepareCondition($column, $value, bool $like = false){
        if(!is_string($column) && !is_array($column))
            throw new \Exception("Column does not meet type constraints. It aught being string or array.");
        $condition = "";
        $values = [];
        if($like){
            if(is_array($column))
                $column = implode("`, `", $column);
            $values[] = preg_replace_callback('/([^\s]+)/', function ($m){
                return "+{$m[1]}";
            }, $value);
            $condition = "MATCH(`{$column}`) AGAINST(? IN BOOLEAN MODE)";
        } else {
            if(!is_array($column))
                $column = [$column];
            foreach ($column as $item){
                $condition .= ($condition?" AND ":"")."`{$item}` = ?";
                $values[] = $value;
            }
        }

        return self::getAdapter()
            ->select($this)
            ->where($condition, $values)
        ;
    }

    /**
     * @param string|string[] $column
     * @param $value
     * @param bool $like
     * @param string|null $orderKey
     * @param bool $direction
     * @param null $limit
     * @param int $offset
     * @return array
     */
    public function getBy($column, $value, bool $like = false, $orderKey = null, $direction = true, $limit = null, $offset = 0): array {
        $storable = $this->prepareCondition($column, $value, $like);
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
     * @return int
     * @internal param null|string $orderKey
     * @internal param bool $direction
     */
    public function getCountBy(string $column, $value, bool $like = false): int {
        $storable = $this->prepareCondition($column, $value, $like);
        return $storable->count();
    }

    /**
     * @param string $column
     * @param $value
     * @param bool $like
     * @param string $field
     * @return float
     */
    public function getAvgBy(string $column, $value, bool $like = false, string $field = "id"): float {
        $storable = $this->prepareCondition($column, $value, $like);
        if($avg = $storable->avg($field))
            return $avg;
        return 0;
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
        Arbeiter::getInstance()
            ->getEventContainer()
            ->trigger("dtoReset", $object);
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