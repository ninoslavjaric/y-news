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
        for($i=0; $i<=$total; $i++){
            if($i == 0){
                if($page-1)
                    $params['page'] = $page-1;
                $pages[] = (object)[
                    'title' =>  "Previous",
                    'url'   =>  "{$url}?".http_build_query($params),
                ];
            }
            if($i<$total){
                $params['page'] = $i+1;
                $pages[] = (object)[
                    'title' =>  $i+1,
                    'url'   =>  "{$url}?".http_build_query($params),
                ];
            } else {
                $params['page'] = $page+1;
                $pages[] = (object)[
                    'title' =>  "next",
                    'url'   =>  "{$url}?".http_build_query($params),
                ];
            }
        }
        return $pages;
    }
}