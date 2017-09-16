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
    public function getScience(){
        $category = Category::getInstance()->getOneBy('key',"science");
        $articles = Article::getInstance()->getBy('category_id', 2);
        return new Response(['articles'=>$articles]);
    }
    public function getTech(){
        $category = Category::getInstance()->getOneBy('key',"tech");

        $articles = Article::getInstance()->getBy('category_id', 2);

        return new Response(['articles'=>$articles]);
    }
    public function getWorld(){

        $category = Category::getInstance()->getOneBy('key',"world");
        $articles = Article::getInstance()->getBy('category_id', $category->getKey());

        return new Response(['articles'=>$articles]);
    }
    public function getPolitics(){

        $category = Category::getInstance()->getOneBy('key',"politics");
        $articles = Article::getInstance()->getBy('category_id', 2);

        return new Response(['articles'=>$articles]);
    }
    public function getHealth(){
        $category = Category::getInstance()->getOneBy('key',"health");
        $articles = Article::getInstance()->getBy('category_id', 2);

        return new Response(['articles'=>$articles]);
    }
}