<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:23 AM
 */

namespace Dao;


abstract class Model
{
    /**
     * @return Model[]
     */
    public function getAll(): array {
        return null;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model{
        return null;
    }

    /**
     * @param string $column
     * @param $value
     * @return Model[]
     */
    public function getBy(string $column, $value): array {
        return null;
    }

}