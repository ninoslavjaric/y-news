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

interface Storable extends Instanceable
{
    /**
     * @return Storable
     */
    public function save():Storable;

    /**
     * @param Dao $dao
     * @return Storable
     */
    public function select(Dao $dao):Storable;

    /**
     * @param string $condition
     * @return Storable
     */
    public function where(string $condition):Storable;

    /**
     * @param $key
     * @param bool $asc
     * @return Storable
     */
    public function orderBy($key, $asc = true):Storable;

    /**
     * @param string $type
     * @return Dto[]
     */
    public function get(string $type);
}