<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 10:06 PM
 */

namespace Bravo\Lib\Database;


interface Initializable
{
    public static function getInstance(array $params): Initializable;
}