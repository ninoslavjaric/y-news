<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:21 PM
 */

namespace Bravo\Dao;


use Bravo\Lib\Dao;

class Category extends Dao
{
    public $table = "categories";
    public $dtoType = \Bravo\Dto\Category::class;

}