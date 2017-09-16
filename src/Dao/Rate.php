<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:21 PM
 */

namespace Bravo\Dao;


use Bravo\Lib\Dao;

class Rate extends Dao
{
    public static $table = "rates";
    public static $dtoType = \Bravo\Dto\Rate::class;

}