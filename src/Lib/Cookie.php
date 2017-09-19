<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/10/17
 * Time: 4:58 PM
 */

namespace Bravo\Lib;


class Cookie
{
    public static function addRatedArticle(int $id){
        $ratedOnes = self::getRatedArticles();
        $ratedOnes[] = $id;
        $ratedOnes = serialize(array_unique($ratedOnes));
        setcookie('rated_articles', $ratedOnes, time() + (10 * 365 * 24 * 60 * 60), "/");
    }

    public static function getRatedArticles(){
        if($ratedOnes = static::get('rated_articles'))
            return unserialize($ratedOnes);
        return [];
    }

    private static function get(string $string)
    {
        if(isset($_COOKIE[$string]))
            return $_COOKIE[$string];
        return null;
    }
}