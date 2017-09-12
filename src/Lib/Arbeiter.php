<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:40 AM
 */

namespace Bravo\Lib;


use Bravo\Controller\IndexController;
use Bravo\Lib\Controller\Container;
use Bravo\Lib\Controller\ErrorController;
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
    public static $controller;

    public static function init(){
        ini_set("display_errors", "on");


        self::initExceptionHandler();
//        self::initErrorHandler();
        static::initEventContainer();
        static::initRequest();
        static::initController();
        static::printResponse();
    }
//    private static function initErrorHandler(){
//        set_error_handler(function($a, $b, $c, $d, $e){
//            var_dump([$a, $b, $c, $d, $e]);
//            $container = new Container(new ErrorController, "getError", [new Exception($b)]);
//            Arbeiter::$controller = $container
//                ->getController()
//                ->setRequest(Arbeiter::$request)
//                ->setResponse($container->getResponse())
//            ;
//            Arbeiter::printResponse();
//        });
//    }
    private static function initExceptionHandler(){
        set_exception_handler(function ($e){
            $container = new Container(new ErrorController, "getIndex", [$e]);
            Arbeiter::$controller = $container
                ->getController()
                ->setRequest(Arbeiter::$request)
                ->setResponse($container->getResponse())
            ;
            Arbeiter::printResponse();
        });
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
        if(!self::$controller)
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
}