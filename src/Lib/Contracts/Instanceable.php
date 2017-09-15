<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 10:06 PM
 */

namespace Bravo\Lib\Contracts;

interface Instanceable
{
    /**
     * @return Instanceable
     */
    public static function getInstance(): Instanceable;
}