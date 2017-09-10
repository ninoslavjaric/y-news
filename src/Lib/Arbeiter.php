<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:40 AM
 */

namespace Bravo\Lib;


use Bravo\Controller\IndexController;
use Bravo\Lib\Event\EventContainer;
use Bravo\Lib\Http\Request;
use Exception;

class Arbeiter
{
    /**
     * @var EventContainer
     */
    private static $eventContainer;

    /**
     * @var Request
     */
    private static $request;
    /**
     * @var Controller
     */
    private static $controller;

    public static function init(){
        set_exception_handler(function ($e){
            die;
        });
        static::initEventContainer();
        static::initRequest();
        static::initController();
        static::printResponse();
    }

    private static function initEventContainer(){
        static::$eventContainer = new EventContainer;
    }

    public static function getEventContainer():EventContainer{
        return static::$eventContainer;
    }

    private static function initRequest(){
        $request = (new Request)
            ->setParams($_REQUEST)
            ->setHeaders(getallheaders())
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setPath($_SERVER['REQUEST_URI'])
        ;
        static::$request = $request;
    }

    /**
     * Inits and processes a request
     */
    private static function initController()
    {
        $container = self::$request->getControllerContainer();
        $container->validate();
        self::$controller = $container
            ->getController()
            ->setRequest(self::$request)
            ->setResponse($container->getResponse())
        ;
    }

    private static function printResponse()
    {
        echo static::$controller->getResponse();
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