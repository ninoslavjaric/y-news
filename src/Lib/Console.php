<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/13/17
 * Time: 12:53 AM
 */

namespace Bravo\Lib;


abstract class Console
{
    protected $name;
    abstract protected function init();
}