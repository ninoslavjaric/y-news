<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 2:06 AM
 */

namespace Bravo\Controller;


use Bravo\Lib\Pagination\Item;
use Bravo\Lib\Pagination\Listing;

trait Paginator
{
    /**
     * @param int $amount
     * @param int $limit
     * @param string $url
     * @return Listing
     * @throws \Exception
     */
    private function getPaginator(int $amount, int $limit, string $url = "/"){
        $total = ceil($amount/$limit);
        if(!$total)
            return new Listing([]);
        $params = $this->getRequest()->getParams();
        if(!isset($params['page']))
            $page = 1;
        elseif (!($page = intval($params['page'])))
            $page = 1;
        if($page < 1 || $page > $total)
            throw new \Exception("Pagination number is out of bounds");

        $pages = [];
        for($i=0; $i<=$total; $i++){
            if($i == 0){
                if(($params['page'] = $page-1)<1)
                    $params['page'] = 1;
                $disabled = $params['page'] <= 1;
                $pages[] = new Item("❮ Previous", $disabled, false, $disabled ? "#" : "{$url}?".http_build_query($params));
                if($page > 2)
                    $pages[] = new Item("...", true, false, "#");
            }
            if($i<$total){
                $params['page'] = $i+1;
                if($params['page'] >= $page-2 && $params['page'] <= $page+2){
                    $pages[] = new Item($i+1, $page == $i+1, $page == $i+1, "{$url}?".http_build_query($params));
                }
            } else {
                if(abs($total - $page) > 2)
                    $pages[] = new Item("...", true, false, "#");
                $params['page'] = $page+1;
                $disabled = $page == $i;
                $pages[] = new Item("Next ❯", $disabled, false, $disabled ? "#" : "{$url}?".http_build_query($params));
            }
        }
        return new Listing($pages);
    }
}