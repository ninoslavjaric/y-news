<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:40 AM
 */

namespace Bravo\Lib;


use Bravo\Lib\Event\EventListener;
use Exception;

class Arbeiter
{
    /**
     * @var EventListener
     */
    public static $eventListener;
    public static function init(){
//        set_error_handler(function($a, $b, $c, $d, $e){
//            var_dump([$a, $b, $c, $d, $e]);
//        });
//        set_exception_handler(function(\Exception $e){
//            var_dump($e);
//        });

        $cft = Config::get("database.redis");
        static::$eventListener = new EventListener;
        static::$eventListener->addEvent("djes", function($object){
            echo "djes";
        });
        static::$eventListener->trigger("djes", (object)['test'=>123]);
        die;
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