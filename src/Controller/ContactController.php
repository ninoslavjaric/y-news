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
use Bravo\Lib\Session;

class ContactController extends Controller
{
    use Validator;
    public function getIndex(){
        return new Response(['title'=>"Contact"], "contact/index");
    }
    public function postIndex(){
        if("/contact" != str_replace($this->request->getOrigin(), "", $this->request->getReferer()))
            throw new \Exception("Wrong referer");
        $this->validate($this->request->getParams(), [
            'email' =>  "email",
            'first-name'    =>  "max:15|min:3",
            'last-name'     =>  "max:15|min:3",
            'subject'       =>  "max:15|min:5",
            'body'          =>  "min:15|max:1000",
        ]);
        return $this->redirect("/contact");
    }
}