<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/13/17
 * Time: 12:53 AM
 */

namespace Bravo\Lib;


abstract class Console
{
    protected $name;
    abstract protected function execute();
    final public static function consoleInject(array $arguments){
        /** @var \ReflectionClass $reflection */
        /** @var self $object */
        $cName = array_shift($arguments);
        $namespacePrefix = "\\Bravo\\Console\\";
        $path = PROJECT_ROOT."/src/Console";
        $classes = [];
        $files = glob("{$path}/*.php");
        foreach ($files as $file){
            $name = basename($file, ".php");
            $class = "{$namespacePrefix}{$name}";
            $reflection = new \ReflectionClass($class);
            if(!preg_match('/\@name\s+([^\n\s]+)/', $reflection->getDocComment(), $matches))
                continue;
            $classes[$matches[1]]['class']      = $class;
            $classes[$matches[1]]['reflection'] = $reflection;
        }
        if(!isset($classes[$cName]))
            throw new \Exception("No console class with @name '{$cName}'");
        $options = [];
        foreach (array_chunk($arguments, 2) as $item) {
            $options[$item[0]] = $item[1];
        }
        $class = $classes[$cName]['class'];
        $reflection = $classes[$cName]['reflection'];
        preg_match_all('/\@option\s+([^\n\s]+)/', $reflection->getDocComment(), $matches);
        if(count($matches[1]) != count($options))
            throw new \Exception("Number of options doesn't match with class '{$class}' options number.");
        $object = new $class;
        $object->name = $cName;
        foreach ($options as $key => $option){
            if(!in_array($key, $matches[1]))
                throw new \Exception("Class '{$class}' doesn't have option under key '{$key}'");
            $object->{"$key"} = $option;
        }
        $object->execute();
    }
}