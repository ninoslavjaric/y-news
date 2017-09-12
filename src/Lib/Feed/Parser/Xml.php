<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/13/17
 * Time: 12:10 AM
 */

namespace Bravo\Lib\Feed\Parser;


use Bravo\Lib\Feed\Item;
use Dto\Article;

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

    public function getItems(){
        $items = [];
        foreach ($this->channel->children() as $child){
            if($child->getName() == "item"){
                $item = new Article;
                foreach ($child->children() as $attribute)
                    if(property_exists($item, $attribute->getName()))
                        $item->{$attribute->getName()} = $attribute->__toString();
                $items[] = $item;
            }
        }
        return $items;
    }
}