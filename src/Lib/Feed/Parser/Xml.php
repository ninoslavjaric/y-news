<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/13/17
 * Time: 12:10 AM
 */

namespace Bravo\Lib\Feed\Parser;


use \Bravo\Dto\Article;

class Xml extends \SimpleXMLElement
{
    private $resource;

    /**
     * @param $resource
     * @return Xml
     */
    public static function getInstance($resource){
        return new self(file_get_contents($resource));
    }

    /**
     * @return Article[]
     */
    public function getArticles():array {
        $items = [];
        foreach ($this->channel->children() as $child){
            if($child->getName() == "item"){
                $item = new Article;
                foreach ($child->children() as $attribute)
                    if(property_exists($item, $attribute->getName()) && method_exists($item, ($method = "set".ucfirst($attribute->getName()))))
                        call_user_func_array([$item, $method],[$this->filter($method, $attribute->__toString())]);
                $items[] = $item;
            }
        }
        return $items;
    }

    /**
     * @param string $method
     * @param string $data
     * @return mixed
     */
    private function filter(string $method, string $data){
        $method = new \ReflectionMethod(Article::class, $method);
        $parameters = $method->getParameters();
        if(count($parameters))
            $parameter = current($parameters);
        else
            return null;
        $type = $parameter->getClass();
        if(!$type)
            return $data;
        if($type->name == \DateTime::class){
            return (new \DateTime)->setTimestamp(strtotime($data));
        }
        return null;
    }
}