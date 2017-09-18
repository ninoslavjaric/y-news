<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/15/17
 * Time: 3:12 PM
 */
return [
    'adapter'   =>  \Bravo\Lib\Database\Redis::class,
    'events'    =>  [
        'dtoReset' =>  function(\Bravo\Lib\Dto $object){
            $class = get_class($object);
            $dtoKey = "{$class}:id:{$object->getId()}";
            \Bravo\Lib\Cache::del($dtoKey, $object);
            \Bravo\Lib\Cache::set($dtoKey, $object);
        }
    ],
];