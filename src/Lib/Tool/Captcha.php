<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/19/17
 * Time: 4:54 PM
 */

namespace Bravo\Lib\Tool;


use Bravo\Lib\Config;
use Bravo\Lib\Session;

class Captcha
{
    private $url = "https://www.google.com/recaptcha/api/siteverify";
    private static $instance;
    private $siteKey;
    private $secretKey;

    private function __construct(array $config)
    {
        $this->siteKey = $config['key'];
        $this->secretKey = $config['secret'];

    }

    public static function getInstance(){
        if(!isset(self::$instance))
            self::$instance = new self(Config::get("app.reCaptcha"));
        return self::$instance;
    }

    public function check(string $response){
        $query = [
            'secret'    =>  $this->secretKey,
            'response'  =>  $response,
        ];
        $query = http_build_query($query);
        $response = file_get_contents("{$this->url}?{$query}");
        $response = json_decode($response, true);
        if(!($ok = $response['success']))
            Session::addFlashErrorMessages("You're not a human.");
        return $ok;
    }
}