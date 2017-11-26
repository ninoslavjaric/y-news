<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 11/26/17
 * Time: 4:41 PM
 */

namespace Bravo\Controller;

use Bravo\Lib\Controller;
use Bravo\Lib\Http\JsonResponse;
use Bravo\Lib\Http\Response;
use Bravo\Lib\Session;

class TrackingController extends Controller
{
    public function postIndex(){
        if($this->getRequest()->isAjax()){

        }
        return new JsonResponse(['title'=>"Ok"]);
    }
    public function getSessionid(){
        return new JsonResponse([
            'id'    =>  Session::getSessionId(),
        ]);
    }
}