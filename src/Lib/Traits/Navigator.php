<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 8:11 PM
 */

namespace Bravo\Lib\Traits;


use Bravo\Lib\Navigation\Item;
use Bravo\Lib\Navigation\Listing;

trait Navigator
{
    /**
     * @param Listing[] $data
     * @param string $url
     * @return array
     */
    private function getNavigations(array $data, string $url){
        foreach ($data as $key => &$items){
            foreach ($items as &$item)
                $item = new Item($item['title'], $item['href'], $item['href']==$url);
            $items = new Listing($items);
            $items->setKey($key);
        }
        return $items;
    }
}