<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/13/17
 * Time: 12:55 AM
 */

namespace Bravo\Console;


use Bravo\Dao\Article;
use Bravo\Dao\Category;
use Bravo\Lib\Config;
use Bravo\Lib\Console;
use Bravo\Lib\Feed\Parser\Xml;

/**
 * Class NewsPuller
 * @package Bravo\Console
 * @name bravo-news
 * @option -c
 */
class NewsPuller extends Console
{

    protected function execute()
    {
        $catDao = Category::getInstance();
        $categories = $catDao->getBy("key", $this->{"-c"});
        if(count($categories))
            $category = current($categories);
        else
            return;
        $feed = Config::get("news.{$category->getKey()}");
        $articles = Xml::getInstance($feed)->getArticles();
        foreach ($articles as &$article){
            $article->setCategory($category);
            if($check = Article::getInstance()->getBy('guid', $article->getGuid())){
                $check = current($check);
                $article->setId($check->getId());
            }
            Article::getInstance()->persist($article);
        }

    }
}