<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 3:49 PM
 */

namespace Bravo\Lib\Http;


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
    public function getParam(string $key): string
    {
        return $this->params[$key];
    }

}