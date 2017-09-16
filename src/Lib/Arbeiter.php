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
use Bravo\Lib\Contracts\Instanceable;
use Bravo\Lib\Event\EventContainer;
use Bravo\Lib\Http\Request;
use Exception;

final class Arbeiter implements Instanceable
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
     * @return Instanceable
     */
    public static function getInstance(): Instanceable{
        if(!isset(self::$instance))
            self::$instance = new static;
        return self::$instance;
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

        set_exception_handler(function (\Exception $e){
            $content = date('l jS \of F Y h:i:s A')."\t{$e->getMessage()}\t{$e->getFile()}\t{$e->getLine()}";
            file_put_contents(PROJECT_ROOT."/logs/exceptions.log", $content, FILE_APPEND);
            if(!Config::get("app.debug"))
                die;
            $container = new Container(new ErrorController, "getIndex", [$e]);
            Arbeiter::getInstance()->setController($container
                ->getController()
                ->setRequest(Arbeiter::getInstance()->getRequest())
                ->setResponse($container->getResponse())
            )->printResponse();
        });
        return $this;
    }

    private function initEventContainer(){
        $this->eventContainer = new EventContainer;
        return $this;
    }

    public function getEventContainer():EventContainer{
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