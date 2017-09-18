<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/18/17
 * Time: 2:06 AM
 */

namespace Bravo\Controller;


trait Paginator
{
    private function getPaginator(int $amount, int $limit, string $url = "/"){
        $total = ceil($amount/$limit);
        $params = $this->getRequest()->getParams();
        if(!isset($params['page']))
            $page = 1;
        elseif (is_int($params['page']))
            $page = 1;
        else
            $page = intval($params['page']);
        $pages = [];
        for($i=0; $i<=$total; $i++)
            $pages[] = 1;
        return null;
    }
}