<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 6:58 PM
 */

namespace Bravo\Lib\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class Container
{
    /**
     * @var Controller
     */
    private $controller;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $parameters;

    /**
     * Generator constructor.
     * @param Controller $controller
     * @param string $method
     * @param array $parameters
     */
    public function __construct(Controller $controller, string $method = "getIndex", array $parameters = [])
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->parameters = $parameters;
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getControllerType(): string {
        return get_class($this->controller);
    }

    /**
     * @return \ReflectionMethod
     */
    public function getMethodDefinition():\ReflectionMethod{
        return new \ReflectionMethod($this->getControllerType(), $this->getMethod());
    }

    /**
     * @return bool
     */
    public function validateParams():bool {
        return $this->getMethodDefinition()->getNumberOfRequiredParameters() <= $this->getParamsCount();
    }

    /**
     * @return int
     */
    public function getParamsCount():int {
        return count($this->parameters);
    }

    public function validate(){
        if(!method_exists($this->controller, $this->method))
            throw new \Exception("Controller '{$this->getControllerType()}' has no method like {$this->getMethod()}");
        if(!$this->validateParams())
            throw new \Exception("Controller '{$this->getControllerType()}' requires more parameters than {$this->getParamsCount()} in method {$this->getMethod()}");
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function getResponse():Response
    {
        if(($response = call_user_func_array([$this->controller, $this->method], $this->parameters)) instanceof Response)
            return $response;
        throw new \Exception("Controller '{$this->getControllerType()}' method '{$this->method}' must return type ".Response::class);
    }
}