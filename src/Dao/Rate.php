<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/8/17
 * Time: 11:21 PM
 */

namespace Bravo\Dao;


use Bravo\Lib\Arbeiter;
use Bravo\Lib\Cache;
use Bravo\Lib\Dao;
use Bravo\Dto\Article;

class Rate extends Dao
{
    public static $table = "rates";
    public static $dtoType = \Bravo\Dto\Rate::class;

    /**
     * Rate constructor.
     */
    public function __construct()
    {
    }


    public function getAvgByArticle(Article $article){
        $class = get_class($article);
        if(!($rating = Cache::get("{$class}:rating:{$article->getId()}")))
            $rating = $this->resetAvgByArticle($article);
        return $rating;
    }

    public function resetAvgByArticle(Article $article){
        $class = get_class($article);
        $rating = (static::getInstance())
            ->getAvgBy('article_id', $article->getId(), false, 'rate');
        Cache::set("{$class}:rating:{$article->getId()}", $rating);
        return $rating;
    }

    public function save(array $data){

    }
}