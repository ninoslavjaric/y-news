<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 11:57 AM
 */

namespace Bravo\Lib;
use Bravo\Lib\Traits\ContainerBehaviour;

/**
 * Class Dto
 * @package Bravo\Lib
 * @property int $id
 * @method string getDaoClass()
 * @method string getTable()
 */
class Dto
{
    use ContainerBehaviour;

    protected $id = 0;

    public function __call($name, $arguments)
    {
        $allowedProps = ["table", "daoClass"];
        if(!preg_match('/^get(.+)$/', $name, $matches))
            throw new \Exception("Method {$name} is not existing.");
        $property = lcfirst($matches[1]);
        if(in_array($property, $allowedProps)){
            $daoClass = str_replace("Dto", "Dao", get_class($this));
            switch ($property){
                case "table":
                    return $daoClass::$table;
                case "daoClass":
                    return $daoClass;
            }
        }
        throw new \Exception("Property {$property} is not existing or is not allowed.");
    }

    /**
     * Dto constructor.
     * @param int $id
     * @return $this
     */
    final public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }
}