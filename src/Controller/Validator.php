<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/19/17
 * Time: 12:06 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Session;

trait Validator
{
    private function validate(array $params, array $rules){
        $ok = true;
        $errorMessages = [];
        foreach ($params as $key => $param){
            if(in_array($key, array_flip($rules))){
                $rArr = explode("|",$rules[$key]);
                foreach ($rArr as $item) {
                    if(preg_match('/max:(\d+)/', $item, $matches)){
                        if(strlen($param) > $matches[1]){
                            $errorMessages[] = "Max {$key} length is {$matches[1]}!";
                            $ok = false;
                        }
                    }elseif(preg_match('/min:(\d+)/', $item, $matches)){
                        if(strlen($param) < $matches[1]){
                            $errorMessages[] = "Min {$key} length is {$matches[1]}!";
                            $ok = false;
                        }
                    } elseif ($item == "email"){
                        if(!filter_var($param, FILTER_VALIDATE_EMAIL)){
                            $errorMessages[] = "{$key} is not email!";
                            $ok = false;
                        }
                    }
                }
            }
        }
        if($errorMessages)
            Session::setFlashErrorMessages($errorMessages);
        return $ok;
    }
}