<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 3:49 PM
 */

namespace Bravo\Lib\Http;


use Bravo\Controller\IndexController;
use Bravo\Lib\Controller\Container;

class Request
{
    /**
     * @var array
     */
    private $params;
    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getParam(string $key)
    {
        if(isset($this->params[$key]))
            return $this->params[$key];
        return null;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path)
    {
        preg_match('/^([^?]+)/', $path, $match);
        $this->path = $match[1];
        return $this;
    }

    /**
     * @return Container
     */
    public function getControllerContainer(){
        $directive = [
            'controller'  =>  IndexController::class,
            'method'   =>  strtolower($this->getMethod()).'Index'
        ];
        $path = $this->getPath();
        $fragments = explode("/", $path);
        $fragments = array_slice($fragments, 1);
//        array_shift($fragments);
        foreach ($fragments as $key => $fragment) {
            if($key < 2 && !($fragment = trim($fragment)))
                continue;
            switch ($key){
                case 0:
                    if(trim($fragment)){
                        $fragment = explode("-", $fragment);
                        foreach ($fragment as &$item)
                            $item = ucfirst($item);

                        $directive['controller'] = "Bravo\\Controller\\".implode("", $fragment)."Controller";
                    }
                    break;
                case 1:
                    if(trim($fragment))
                        $directive['method'] = strtolower($this->getMethod()).ucfirst($fragment);
                    break;
                default:
                    $directive['arguments'][] = $fragment;
            }
        }
        $instance = new $directive['controller'];
        if(isset($directive['arguments']))
            return new Container($instance, $directive['method'], $directive['arguments']);
        return new Container($instance, $directive['method']);
    }
}