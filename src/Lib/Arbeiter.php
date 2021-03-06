<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 11:40 AM
 */

namespace Bravo\Lib;


use Bravo\Lib\Controller\Container;
use Bravo\Lib\Controller\ErrorController;
use Bravo\Lib\Event\EventContainer;
use Bravo\Lib\Http\Request;

final class Arbeiter
{
    /**
     * @var EventContainer
     */
    private $eventContainer;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var static
     */
    private static $instance;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Controller $controller
     * @return Arbeiter
     */
    public function setController(Controller $controller): Arbeiter
    {
        $this->controller = $controller;
        return $this;
    }


    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @return Arbeiter
     */
    public static function getInstance(): Arbeiter{
        if(!isset(self::$instance))
            static::$instance = new static;
        return static::$instance;
    }

    public static function init(){
        if(Config::get("app.debug"))
            ini_set("display_errors", "on");
        self::getInstance()
            ->initExceptionHandler()
            ->initEventContainer()
            ->initRequest()
            ->initController()
            ->printResponse()
        ;
    }

    private function initExceptionHandler(){

        set_exception_handler(function ($e){
            $content = date('l jS \of F Y h:i:s A')."\t{$e->getMessage()}\t{$e->getFile()}\t{$e->getLine()}\n";
            file_put_contents(PROJECT_ROOT."/logs/exceptions.log", $content, FILE_APPEND);
            if(Config::get("app.debug")){
                $container = new Container(new ErrorController, "getIndex", [$e]);
            } else{
                $class = Config::get("app.404.controller");
                if(!$class)
                    die("No 404 controller");
                if(!($method = Config::get("app.404.method")))
                    $method = "getIndex";
                $container = new Container(new $class, $method, []);
            }
            Arbeiter::getInstance()->setController($container
                ->getController()
                ->setRequest(Arbeiter::getInstance()->getRequest())
                ->setResponse($container->getResponse())
            )->printResponse();
        });
        return $this;
    }

    private function initEventContainer(){
        $eventContainer = new EventContainer;
        if($events = Config::get("cache.events"))
            foreach ($events as $key => $event)
                $eventContainer->addEvent($key, $event);
        $this->eventContainer = $eventContainer;
        return $this;
    }

    public function getEventContainer():EventContainer{
        if(!isset($this->eventContainer))
            self::initEventContainer();
        return $this->eventContainer;
    }

    private function initRequest(){
        $request = (new Request)
            ->setParams($_REQUEST)
            ->setHeaders(getallheaders())
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setPath($_SERVER['REQUEST_URI'])
        ;
        $this->request = $request;
        return $this;
    }

    /**
     * Inits and processes a request
     */
    private function initController()
    {
        $container = $this->request->getControllerContainer();
        $container->validate();
        if(!$this->controller)
            $this->controller = $container
                ->getController()
                ->setRequest($this->request)
                ->setResponse($container->getResponse())
            ;
        return $this;
    }

    private function printResponse()
    {
        echo $this->controller->getResponse();
    }
}