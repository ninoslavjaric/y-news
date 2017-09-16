<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:21 PM
 */

namespace Bravo\Dao;


use Bravo\Lib\Dao;
use Bravo\Lib\Dto;

/**
 * Class Article
 * @package Bravo\Dao
 */
class Article extends Dao
{
    public static $table = "articles";
    public static $dtoType = \Bravo\Dto\Article::class;

}