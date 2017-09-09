<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:40 AM
 */

namespace Bravo\Lib;


use Bravo\Lib\Event\EventListener;
use Bravo\Lib\Http\Request;
use Exception;

class Arbeiter
{
    /**
     * @var EventListener
     */
    private static $eventListener;

    /**
     * @var Request
     */
    private static $request;

    public static function init(){
        set_exception_handler(function ($e){
            die;
        });
        static::initEventListener();
        static::initRequest();
        die;
    }

    private static function initEventListener(){
        static::$eventListener = new EventListener;
    }

    public static function getEventListener():EventListener{
        return static::$eventListener;
    }

    private static function initRequest(){
        $h = \getallheaders();
        $request = new Request($_REQUEST, getallheaders());
        static::$request = $request;
        unset($_REQUEST);
    }


//    private static function setHandlers(){
//        set_error_handler(function($a, $b, $c, $d, $e){
//            var_dump([$a, $b, $c, $d, $e]);
//        });
//        trigger_error("Cannot divide by zero", E_USER_ERROR);
//        set_exception_handler(self::exceptionHandler);
//    }
//
//    private static function exceptionHandler(Exception $e){
//        var_dump($e);
//    }
//
//    private static function errorHandler(int $errno, string $errstr, string $errfile, int $errline, array $context){
//        var_dump([$errno, $errstr, $errfile, $errline, $context]);
//    }

}