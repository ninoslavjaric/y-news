<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 11:57 AM
 */

namespace Bravo\Lib;

/**
 * Class Dto
 * @package Bravo\Lib
 * @property int $id
 */
class Dto
{
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