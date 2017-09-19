<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/12/17
 * Time: 12:20 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Config;
use Bravo\Lib\Controller;
use Bravo\Lib\Http\JsonResponse;
use Bravo\Lib\Http\Response;
use Bravo\Lib\Mailer;
use Bravo\Lib\Session;
use Bravo\Lib\Tool\Captcha;

class ContactController extends Controller
{
    use Validator;
    public function getIndex(){
        return new Response(['title'=>"Contact"], "contact/index");
    }
    public function postIndex(){
        if("/contact" != str_replace($this->request->getOrigin(), "", $this->request->getReferer()))
            throw new \Exception("Wrong referer");
        $paramsValid = $this->validate(
            $this->request->getParams(),
            [
                'email' =>  "email",
                'first-name'    =>  "max:15|min:3",
                'last-name'     =>  "max:15|min:3",
                'subject'       =>  "max:55|min:5",
                'body'          =>  "min:15|max:1000",
            ]);
        $isHuman = Captcha::getInstance()->check($this->getParam("g-recaptcha-response"));
        if(!$paramsValid || !$isHuman)
            return $this->redirect("/contact");

        $mailer = new Mailer(
            $this->getParam("email"),
            Config::get("app.contact-email"),
            $this->getParam("subject"),
            $this->getParam("body")
        );

        $mailer->setFrom($this->getParam("email"), $this->getParam("first-name"), $this->getParam("last-name"));
        if($sucess = $mailer->send())
            Session::setFlashReportMessages(["Message is successfully sent"]);
        return $this->redirect("/contact");
    }
}