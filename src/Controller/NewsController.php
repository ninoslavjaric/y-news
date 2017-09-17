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
use Bravo\Lib\Http\Response;

class NewsController extends Controller
{
    /**
     * @param $key
     * @return Response
     */
    private function pickData($key){
        $category = Category::getInstance()->getOneBy('key', $key);
        /** @var \Bravo\Dto\Category $category */
        return new Response([
            'articles'  =>  $category->getArticles("pub_date", false, 6),
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
        $query = $this->getRequest()->getParam("search");
        $articles = Article::getInstance()->getBy('description', $query, true, 'pub_date', false, 6);
        return new Response([
            'articles'  =>  $articles,
            'title'     =>  "Search results by \"{$query}\"",
            'search'    =>  $query,
        ]);
    }
}