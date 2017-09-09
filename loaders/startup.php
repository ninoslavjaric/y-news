<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:42 AM
 */
define('PROJECT_ROOT', __DIR__."/..");
$loaders = [];
foreach (glob(__DIR__ . "/*.php") as $item)
    if($item != __FILE__)
        include_once $item;