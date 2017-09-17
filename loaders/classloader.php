<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:08 PM
 */
spl_autoload_register(function($class){
    $file = str_replace(["Bravo", "\\"], ["src", "/"], $class);
    $file = PROJECT_ROOT."/{$file}.php";
    if(!file_exists($file))
        throw new Exception("File {$file} is not existed!", 358);
    require_once $file;
});