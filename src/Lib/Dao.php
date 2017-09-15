<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:23 AM
 */

namespace Bravo\Lib;


abstract class Dao
{
    private static function getDbAdapter(){

    }
    /**
     * @return Dao[]
     */
    public function getAll(): array {
        return null;
    }

    /**
     * @param int $id
     * @return Dao
     */
    public function getById(int $id): Dao{
        return null;
    }

    /**
     * @param string $column
     * @param $value
     * @return Dao[]
     */
    public function getBy(string $column, $value): array {
        return null;
    }

}