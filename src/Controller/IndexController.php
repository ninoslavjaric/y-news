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
        $articles = Article::getInstance()->getAll('pub_date', false, 6);
        $paginator = $this->getPaginator(Article::getInstance()->getCountAll(), 6);
        return new Response([
            'title'     =>  "Latest news",
            'articles'  =>  $articles
        ]);
    }
}