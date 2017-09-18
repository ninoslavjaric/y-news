<?php
/**
 * Created by PhpStorm.
 * User: nino
 * Date: 9/17/17
 * Time: 2:08 PM
 */

namespace Bravo\Lib\Tool;


class Stringer
{
    public static function filterTitle($string){
        return self::filter($string, 70);
    }

    public static function filterDescription($string){
        return self::filter($string, 100);
    }

    private static function filter($string, $limit){
        if(strlen($string) <= $limit)
            return $string;
        $string = explode(" ", $string);
        $collector = "";
        foreach ($string as $item){
            $collector .= " {$item}";
            if(strlen($collector) > $limit)
                return "{$collector} ...";
        }
        return $string;
    }

    public static function filterSpecChrs(string $string){
        $disputeds = [
            '&lt;', '&gt;', '&amp;', '&quot;', '&apos;', '&cent;', '&pound;', '&yen;', '&euro;', '&copy;', '&reg;', '&#60;', '&#62;', '&#38;', '&#34;', '&#39;', '&#162;', '&#163;', '&#165;', '&#8364;', '&#169;', '&#174;',
        ];
        $replacements = [
            "<", ">", "&", "\"", "'", "¢", "£", "¥", "€", "©", "®", "<", ">", "&", "\"", "'", "¢", "£", "¥", "€", "©", "®",
        ];
        return str_replace($disputeds, $replacements, $string);
    }

}