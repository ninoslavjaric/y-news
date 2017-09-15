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
use Bravo\Lib\Contracts\Storable;
use Bravo\Lib\Dao;
use Bravo\Lib\Dto;

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
     * @return Storable
     */
    public function save(): Storable
    {
        // TODO: Implement save() method.
    }

    /**
     * @param Dao $dao
     * @return Storable
     */
    public function select(Dao $dao): Storable
    {
        $this->query = "SELECT * FROM `{$dao->table}`";
        return $this;
    }

    /**
     * @param string $condition
     * @return Storable
     */
    public function where(string $condition): Storable
    {
        // TODO: Implement where() method.
    }

    /**
     * @param $key
     * @param bool $asc
     * @return Storable
     */
    public function orderBy($key, $asc = true): Storable
    {
        // TODO: Implement orderBy() method.
    }

    /**
     * @param string $type
     * @return Dto[]
     */
    public function get(string $type)
    {
        if ($stmt = $this->prepare($this->query)) {

//            /* bind parameters for markers */
//            $stmt->bind_param("s", $city);

            /* execute query */
            $stmt->execute();

            /* bind result variables */
//            $stmt->bind_result($district);

            $result = $stmt->get_result();

            /* fetch value */
//            $stmt->fetch();
            $dtos = [];
            while ($dto = $result->fetch_object($type)) {
                $dtos[] = $dto;
            }

            /* close statement */
            $stmt->close();
        }
    }
}