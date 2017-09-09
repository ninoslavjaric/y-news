<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:08 PM
 */
spl_autoload_register(function($class){
    $file = str_replace(["Bravo", "\\"], ["src", "/"], $class);
    $file = "../{$file}.php";
    require_once $file;
});