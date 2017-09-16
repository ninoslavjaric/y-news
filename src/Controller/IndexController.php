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
        $articles = Article::getInstance()->getBy('category_id', 2);

        return new Response(['articles'=>$articles]);
    }
}