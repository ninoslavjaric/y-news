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
    public function getIndex(){
        $articles = Article::getInstance()->getAll('pub_date', false);

        return new Response([
            'title'     =>  "Latest news",
            'articles'  =>  $articles
        ]);
    }
}