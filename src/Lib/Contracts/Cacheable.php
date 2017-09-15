<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 3:07 PM
 */

namespace Bravo\Lib\Contracts;


interface Cacheable
{
    public function getItem($key):string ;
    public function setItem($key, $value):Cacheable;
    public function removeItem($key):Cacheable;
}