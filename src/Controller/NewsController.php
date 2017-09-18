<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/12/17
 * Time: 11:51 PM
 */

namespace Bravo\Controller;


use Bravo\Dao\Article;
use Bravo\Dao\Category;
use Bravo\Lib\Controller;
use Bravo\Lib\Http\JsonResponse;
use Bravo\Lib\Http\Response;

class NewsController extends Controller
{
    use Paginator;
    /**
     * @param $key
     * @return Response
     */
    private function pickData($key){
        $category = Category::getInstance()->getOneBy('key', $key);
        /** @var \Bravo\Dto\Category $category */
        if(!($page = $this->getParam("page")))
            $page = 1;
        $limit = 6;

        return new Response([
            'articles'  =>  $category->getArticles("pub_date", false, $limit, ($limit*(--$page))),
            'paginator' =>  $this->getPaginator($category->getArticlesCount(), $limit, "/news/{$key}"),
            'title'     =>  $category->getTitle(),
        ]);

    }
    public function getScience(){
        return $this->pickData("science");
    }
    public function getTech(){
        return $this->pickData("tech");
    }
    public function getWorld(){
        return $this->pickData("world");
    }
    public function getPolitics(){
        return $this->pickData("politics");
    }
    public function getHealth(){
        return $this->pickData("health");
    }

    public function getIndex(){
        if(!($query = $this->getRequest()->getParam("search")))
            $this->redirect();
        if(!($page = $this->getParam("page")))
            $page = 1;
        $limit = 6;
        $articles = Article::getInstance()->getBy('description', $query, true, 'pub_date', false, 6, ($limit*(--$page)));
        $count = Article::getInstance()
            ->getCountBy('description', $query, true);


        return new Response([
            'articles'  =>  $articles,
            'title'     =>  "Search by \"{$query}\"",
            'search'    =>  $query,
            'paginator' =>  $this->getPaginator(Article::getInstance()
                ->getCountBy('description', $query, true), $limit, "/news"),
        ]);
    }

    public function putIndex(){

        return new JsonResponse([
            "test"  =>  "its ok",
        ]);
    }
}