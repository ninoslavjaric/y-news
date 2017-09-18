<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 5:05 PM
 */

namespace Bravo\Controller;


use Bravo\Dao\Article;
use Bravo\Lib\Controller;
use Bravo\Lib\Http\Response;

class IndexController extends Controller
{
    use Paginator;
    public function getIndex(){
        if(!($page = $this->getParam("page")))
            $page = 1;
        $limit = 6;
        $articles = Article::getInstance()->getAll('pub_date', false, $limit, ($limit*(--$page)));
        return new Response([
            'title'     =>  "Latest news",
            'articles'  =>  $articles,
            'paginator' =>  $this->getPaginator(Article::getInstance()->getCountAll(), $limit),
        ]);
    }
}