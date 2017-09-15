<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 11:57 AM
 */

namespace Bravo\Lib;


class Dto
{
    /**
     * @var int
     */
    private $id;

    /**
     * Dto constructor.
     * @param int $id
     */
    final public function __construct($id = 0)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

}