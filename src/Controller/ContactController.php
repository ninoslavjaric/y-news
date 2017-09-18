<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/12/17
 * Time: 12:20 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Controller;
use Bravo\Lib\Http\JsonResponse;
use Bravo\Lib\Http\Response;

class ContactController extends Controller
{
    public function getIndex(){
        return new Response(['title'=>"Contact"], "contact/index");
    }
    public function postIndex(){
        return new JsonResponse([
            'params'    =>  $this->getRequest()->getParams(),
            'req'       =>  $_SERVER,
        ]);
    }
}