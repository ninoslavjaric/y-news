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
        call_user_func(self::$events[$event], $object);
    }
    public function addEvent(string $key, \Closure $callback){
        self::$events[$key] = $callback;
        self::$events[$key]->bindTo($this);
    }
}