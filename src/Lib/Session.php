<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/19/17
 * Time: 12:23 AM
 */

namespace Bravo\Lib;


class Session
{
    public static function init(){
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }
    public static function setFlashErrorMessages(array $messages){
        self::init();
        $_SESSION['flash_messages'] = $messages;
    }

    public static function getFlashErrorMessages(){
        self::init();
        $flashMessages = [];
        if(isset($_SESSION['flash_messages']))
            $flashMessages = $_SESSION['flash_messages'];
        unset($_SESSION['flash_messages']);
        return $flashMessages;
    }
}