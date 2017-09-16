<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 1:26 AM
 */

if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
function _class_exists($class){
    try{
        return class_exists($class);
    }catch (\Exception $e){
        return false;
    }
}
