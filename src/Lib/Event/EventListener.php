<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/9/17
 * Time: 2:43 AM
 */

namespace Bravo\Lib\Event;


class EventListener
{
    /**
     * @var \Closure[]
     */
    private static $events = [];

    public function trigger(string $event, $object = null){
        $params = func_get_args();
        array_shift($params);
        call_user_func_array(self::$events[$event], $params);
    }
    public function addEvent(string $key, \Closure $callback){
        self::$events[$key] = $callback;
        self::$events[$key]->bindTo($this);
    }
}