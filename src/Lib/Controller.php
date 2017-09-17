<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 4:55 PM
 */

namespace Bravo\Lib;


use Bravo\Lib\Http\Request;
use Bravo\Lib\Http\Response;

class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @param Response $response
     * @return $this
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return Response
     */
    public function getResponse():Response
    {
        return $this->response;
    }

    /**
     *
     */
    public function spit(){
        header("Content-type: {$this->response->getContentType()}");
        echo $this->response;
    }

    public function redirect($url = "/four-o-four"){
        header("Location: {$url}");
    }
}