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

    public static function addFlashErrorMessages(string $messages){
        self::init();
        $_SESSION['flash_error_messages'][] = $messages;
    }
    public static function setFlashErrorMessages(array $messages){
        self::init();
        $_SESSION['flash_error_messages'] = $messages;
    }

    public static function setFlashReportMessages(array $messages)
    {
        self::init();
        $_SESSION['flash_report_messages'] = $messages;
    }

    public static function getFlashReportMessages(){
        return self::getFlashMessages('flash_report_messages');
    }

    public static function getFlashErrorMessages(){
        return self::getFlashMessages('flash_error_messages');
    }

    public static function getFlashMessages($key){
        self::init();
        $flashMessages = [];
        if(isset($_SESSION[$key]))
            $flashMessages = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $flashMessages;
    }
}