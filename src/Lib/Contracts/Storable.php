<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 5:09 PM
 */

namespace Bravo\Lib\Contracts;


use Bravo\Lib\Dao;
use Bravo\Lib\Dto;

interface Storable
{

    /**
     * @param Dao $dao
     * @return Storable
     */
    public function select(Dao $dao):Storable;

    /**
     * @param string $condition
     * @param string[] $params
     * @return Storable
     */
    public function where(string $condition, array $params = []):Storable;

    /**
     * @param $key
     * @param bool $asc
     * @return Storable
     */
    public function orderBy($key, $asc = true):Storable;

    /**
     * @param int $chunk
     * @param bool $offset
     * @return Storable
     */
    public function limit(int $chunk, $offset = false):Storable;


    /**
     * @return Dto[]
     */
    public function get();

    /**
     * @return int
     */
    public function count();

    /**
     * @param string $column
     * @return float
     */
    public function avg(string $column);

    /**
     * @param Dto $object
     * @return $object
     */
    public function insertOrUpdate(Dto $object);
}