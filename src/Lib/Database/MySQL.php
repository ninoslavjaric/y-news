<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:45 AM
 */

namespace Bravo\Lib\Database;


use Bravo\Lib\Cache;
use Bravo\Lib\Config;
use Bravo\Lib\Contracts\Instanceable;
use Bravo\Lib\Contracts\Storable;
use Bravo\Lib\Dao;
use Bravo\Lib\Dto;

/**
 * Class MySQL
 * @package Bravo\Lib\Database
 * @property string[] $cParams
 */
class MySQL extends \mysqli implements Storable
{
    /**
     * @var string
     */
    private $query;
    /**
     * @var array
     */
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
     * @var Dao
     */
    private $dao;

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

    /**
     * @param Dao $dao
     * @param bool $wholeRow
     * @return Storable
     */
    public function select(Dao $dao): Storable
    {
        $this->dao = $dao;
        $this->query = "SELECT `id` FROM `{$dao->getTable()}`";
        return $this;
    }

    /**
     * @param string $condition
     * @param array $params
     * @return Storable
     */
    public function where(string $condition, array $params = []): Storable
    {
        $this->cParams = $params;
        $this->query .= " WHERE {$condition}";
        return $this;
    }

    /**
     * @param $key
     * @param bool $asc
     * @return Storable
     */
    public function orderBy($key, $asc = true): Storable
    {
        $direction = $asc ? "ASC" : "DESC";
        $this->query .= " ORDER BY {$key} {$direction}";
        return $this;
    }

    /**
     * @param int $chunk
     * @param int $offset
     * @return Storable
     */
    public function limit(int $chunk, $offset = 0): Storable
    {
        $this->query .= " LIMIT {$offset}, {$chunk}";
        return $this;
    }

    /**
     * @param string $type
     * @return Dto[]
     * @throws \Exception
     */
    public function get()
    {
        if ($stmt = $this->prepare($this->query)) {
            $params = isset($this->cParams) ? $this->cParams : [];
            if($params){
                $types = "";
                foreach ($params as $key => &$param)
                    $this->typeGenerator($types, $param);
                $bindParams = array_merge([$types], $params);
                if (!call_user_func_array([$stmt, "bind_param"], $bindParams))
                    throw new \Exception("Binding parameters failed: ({$stmt->errno}) {$stmt->error}");
            }
            if (!$stmt->execute())
                throw new \Exception("Execute failed: ({$stmt->errno}) {$stmt->error}");
            $result = $stmt->get_result();
            /** @var Dto $dtos */
            $dtos = [];
            while ($id = $result->fetch_object()){
                $dtoKey = "{$this->dao->getDtoType()}:id:{$id->id}";
                if(!($dto = Dto::getObject($dtoKey))){
                    if(!($dto = Cache::get($dtoKey))){
                        if(($res = $this->query("SELECT * FROM `{$this->dao->getTable()}` WHERE `id` = {$id->id}"))->num_rows){
                            $dto = $res->fetch_object($this->dao->getDtoType());
                            Cache::set($dtoKey, $dto);
                        }
                    }
                    Dto::addObject($dtoKey, $dto);
                }
                $dtos[] = $dto;
            }
            $stmt->close();
            return $dtos;
        }
        throw new \Exception($this->error);
    }

    /**
     * @param Dto $object
     * @return Dto $object
     */
    public function insertOrUpdate(Dto $object)
    {
        $reflector = new \ReflectionObject($object);
        $properties = $reflector->getProperties();
        $fields = [];
        foreach ($properties as $key => &$property){
            if(!($property = $this->propDefFilter($object,$property)))
                continue;
            $fields[$property->column] = $property->value;
        }

        if($id = $object->getId()){
            $types = ""; $columns = [];

            $values = [];
            foreach ($fields as $key => &$field){
                $this->typeGenerator($types, $field);
                $columns[] = "`{$key}`=?";
                $values[] = html_entity_decode($field, ENT_QUOTES | ENT_HTML5);
            }
            $columns = implode(", ", $columns);
            $types .= "i";
            $values[] = $id;
            $this->query = "UPDATE `{$object->getTable()}` SET {$columns} WHERE id=?";
        } else {
            $types = ""; $columns = []; $questions = []; $values = [];

            foreach ($fields as $key => &$field){
                if(trim($key) == "id"){
                    continue;
                }
                $this->typeGenerator($types, $field);
                $columns[] = "`{$key}`";
                $questions[] = "?";
                $values[] = html_entity_decode($field, ENT_QUOTES | ENT_HTML5);
            }
            $columns = implode(", ", $columns);
            $questions = implode(", ", $questions);
            $this->query = "INSERT INTO `{$object->getTable()}` ({$columns}) VALUES ({$questions})";
        }
        if($id = $this->execute($this->query, $types, $values))
            $object->setId($id);

        Cache::del(get_class($object).":id:{$object->getId()}");
        return $object;
    }

    /**
     * @param $query
     * @param $types
     * @param $parameters
     * @return mixed|null
     */
    private function execute($query, $types, $parameters){
        $params = [$types];
        foreach ($parameters as $key => $parameter)
            $params[] = &$parameters[$key];
        try{
            $this->begin_transaction();
            if(!$stmt = $this->prepare($query))
                throw new \Exception($this->error);
            if (!call_user_func_array([$stmt, "bind_param"], $params))
                throw new \Exception("Binding parameters failed: ({$stmt->errno}) {$stmt->error}");
            if (!$stmt->execute())
                throw new \Exception("Execute failed: ({$stmt->errno}) {$stmt->error}");
            $id = $this->insert_id;
            $this->commit();
            return $id;
        }catch (\Exception $e){
            if($this->errno != 1062){
                $content = date('l jS \of F Y h:i:s A')."\t{$e->getMessage()}\t{$e->getFile()}\t{$e->getLine()}\n";
                file_put_contents(PROJECT_ROOT."/logs/exceptions.log", $content, FILE_APPEND);
            }
            $this->rollback();
        }finally{
            if(isset($stmt))
                $stmt->close();
        }
        return null;
    }

    /**
     * @param Dto $object
     * @param \ReflectionProperty $property
     * @return \stdClass
     */
    private function propDefFilter(Dto $object, \ReflectionProperty $property){
        $column = $property->name;
        $type = null;
        if(preg_match('/\@column\s+([^\n]+)/', $property->getDocComment(), $matches))
            $column = $matches[1];
        if(preg_match('/\@var\s+([^\n]+)/', $property->getDocComment(), $matches))
            $type = $matches[1];

        $method = explode("_", $property->name);
        foreach ($method as &$item)
            $item = ucfirst($item);
        $method = "get".implode($method);
        if(!method_exists($object, $method))
            return null;
        $value = call_user_func_array([$object, $method], []);
        if($type){
            if(!in_array($type, ['string','int','integer','bool','boolean','mixed','float','double'])){
                if($value instanceof \DateTime)
                    $value = $value->getTimestamp();
                elseif(_class_exists("Bravo\\Dto\\{$type}"))
                    $value = $value->getId();
            }
        }
        return (object)[
            'column'    =>  $column,
            'value'     =>  $value,
        ];
    }

    private function typeGenerator(string &$types, &$param){
        if (is_double($param))
        {
            $types .= "d";
        }
        elseif (is_int($param))
        {
            $types .= "i";
        }
        elseif (is_bool($param))
        {
            $param = $param ? 1 : 0;
            $types .= "i";
        }
        elseif(is_string($param))
        {
            $types .= "s";
        }
        elseif($param instanceof \DateTime){
            $param = $param->getTimestamp();
            $types .= "i";
        }
    }
}