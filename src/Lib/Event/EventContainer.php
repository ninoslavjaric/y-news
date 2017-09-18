<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:43 AM
 */

namespace Bravo\Lib\Event;


class EventContainer
{
    /**
     * @var \Closure[]
     */
    private static $events = [];

    public function trigger(string $event, $object = null){
        $params = array_slice(func_get_args(),1);
        if(isset(self::$events[$event])){
            call_user_func_array(self::$events[$event], $params);
            return true;
        }
        return false;
    }
    public function addEvent(string $key, \Closure $callback){
        self::$events[$key] = $callback;
        self::$events[$key]->bindTo($this);
    }
}