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
     * @return \Bravo\Dto\Article[]
     */
    private function pickArticles($key){
        $category = Category::getInstance()->getOneBy('key', $key);
        return Article::getInstance()->getBy('category_id', $category->getId());

    }
    public function getScience(){
        return new Response(['articles'=>$this->pickArticles("science")]);
    }
    public function getTech(){
        return new Response(['articles'=>$this->pickArticles("tech")]);
    }
    public function getWorld(){
        return new Response(['articles'=>$this->pickArticles("world")]);
    }
    public function getPolitics(){
        return new Response(['articles'=>$this->pickArticles("politics")]);
    }
    public function getHealth(){
        return new Response(['articles'=>$this->pickArticles("health")]);
    }
}